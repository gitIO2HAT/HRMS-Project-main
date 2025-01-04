using libzkfpcsharp;
using MySql.Data.MySqlClient;
using System;
using System.Data.Common;
using System.Drawing;
using System.IO;
using System.Runtime.InteropServices;
using System.Threading;
using System.Threading.Tasks;
using System.Windows.Forms;
using ZKTecoFingerPrintScanner_Implementation;
using ZKTecoFingerPrintScanner_Implementation.Helpers;

namespace Dofe_Re_Entry.UserControls.DeviceController
{
    public partial class FingerPrintControl : UserControl
    {

        string connectionString = "Server=localhost;Database=hrms_buil_v1;Uid=root;Pwd=;";

        const string VerifyButtonDefault = "Verify";
        const string VerifyButtonToggle = "Stop Verification";
        const string Disconnected = "Disconnected";

        Thread captureThread = null;

        public Master parentForm = null;

        #region -------- FIELDS --------



        zkfp fpInstance = new zkfp();
        IntPtr FormHandle = IntPtr.Zero; // To hold the handle of the form
        bool bIsTimeToDie = false;
        bool IsRegister = false;
        
        byte[] FPBuffer;   // Image Buffer
        int RegisterCount = 0;

        const int REGISTER_FINGER_COUNT = 3;  // Number of fingerprints to register
        byte[][] RegTmps = new byte[REGISTER_FINGER_COUNT][];  // Placeholder for fingerprint templates
        byte[] RegTmp = new byte[2048];  // Array to hold the final registration template
        byte[] CapTmp = new byte[2048];  // Temporary array for capturing the fingerprint
        int cbCapTmp = 2048;  // Size of the CapTmp array
        int regTempLen = 0;  // Variable to store the length of the registration template
        int iFid = 1;  // Fingerprint ID for registration

        const int MESSAGE_CAPTURED_OK = 0x0400 + 6;




        private int mfpWidth = 0;
        private int mfpHeight = 0;


        #endregion


        // [ CONSTRUCTOR ]
        public FingerPrintControl()
        {
            InitializeComponent();
            // To hide the panel
            panel1.Visible = false;
            panel2.Visible = false;
            label5.Visible = false;
            Utilities.EnableControls(false, btnClose, btnEnroll);

            ReInitializeInstance();
        }


        // [ INITALIZE DEVICE ]
        private void bnInit_Click(object sender, EventArgs e)
        {
            label5.Visible = true;
            parentForm.statusBar.Visible = false;
            cmbIdx.Items.Clear();

            int initializeCallBackCode = fpInstance.Initialize();
            if (zkfp.ZKFP_ERR_OK == initializeCallBackCode)
            {
                int nCount = fpInstance.GetDeviceCount();
                if (nCount > 0)
                {
                    for (int i = 1; i <= nCount; i++) cmbIdx.Items.Add(i.ToString());

                    cmbIdx.SelectedIndex = 0;
                    btnInit.Enabled = false;

                    DisplayMessage(MessageManager.msg_FP_InitComplete, true);
                }
                else
                {
                    int finalizeCount = fpInstance.Finalize();
                    DisplayMessage(MessageManager.msg_FP_NotConnected, false);
                }




                // CONNECT DEVICE

                #region -------- CONNECT DEVICE --------

                int openDeviceCallBackCode = fpInstance.OpenDevice(cmbIdx.SelectedIndex);
                if (zkfp.ZKFP_ERR_OK != openDeviceCallBackCode)
                {
                    DisplayMessage($"Uable to connect with the device! (Return Code: {openDeviceCallBackCode} )", false);
                    return;
                }

                Utilities.EnableControls(false, btnInit);
                Utilities.EnableControls(true, btnClose, btnEnroll);

                RegisterCount = 0;
                regTempLen = 0;
                iFid = 1;

                //for (int i = 0; i < 3; i++)
                for (int i = 0; i < REGISTER_FINGER_COUNT; i++)
                {
                    RegTmps[i] = new byte[2048];
                }

                byte[] paramValue = new byte[4];
                int size = 4;

                //fpInstance.GetParameters

                fpInstance.GetParameters(1, paramValue, ref size);
                zkfp2.ByteArray2Int(paramValue, ref mfpWidth);

                size = 4;
                fpInstance.GetParameters(2, paramValue, ref size);
                zkfp2.ByteArray2Int(paramValue, ref mfpHeight);

                FPBuffer = new byte[mfpWidth * mfpHeight];

                //FPBuffer = new byte[fpInstance.imageWidth * fpInstance.imageHeight];

                captureThread = new Thread(new ThreadStart(DoCapture));
                captureThread.IsBackground = true;
                captureThread.Start();


                bIsTimeToDie = false;

                string devSN = fpInstance.devSn;
                lblDeviceStatus.Text = "Connected \nDevice S.No: " + devSN;

                DisplayMessage("You are now connected to the device.", true);



                #endregion

            }
            else
                DisplayMessage("Unable to initailize the device. " + FingerPrintDeviceUtilities.DisplayDeviceErrorByCode(initializeCallBackCode) + " !! ", false);

        }



        // [ CAPTURE FINGERPRINT ]
        private void DoCapture()
        {
            try
            {
                while (!bIsTimeToDie)
                {
                    cbCapTmp = 2048;
                    int ret = fpInstance.AcquireFingerprint(FPBuffer, CapTmp, ref cbCapTmp);

                    if (ret == zkfp.ZKFP_ERR_OK)
                    {
                        // Thread-safe call to UpdateStatusBar
                        UpdateStatusBar("Fingerprint captured successfully.", true);
                        SendMessage(FormHandle, MESSAGE_CAPTURED_OK, IntPtr.Zero, IntPtr.Zero);
                    }
                    Thread.Sleep(100);
                }
            }
            catch (Exception ex)
            {
                // Handle exception and update the UI safely
                UpdateStatusBar($"Error during capture: {ex.Message}", false);
            }
        }




        [DllImport("user32.dll", EntryPoint = "SendMessageA")]
        public static extern int SendMessage(IntPtr hwnd, int wMsg, IntPtr wParam, IntPtr lParam);



        private void UpdateStatusBar(string message, bool isSuccess)
        {
            // Check if parentForm and statusBar are not null, and ensure this runs on the UI thread
            if (parentForm != null && parentForm.statusBar != null && parentForm.statusBar.InvokeRequired)
            {
                // If invoked from another thread, use Invoke to run the action on the UI thread
                parentForm.statusBar.Invoke(new Action<string, bool>(UpdateStatusBar), new object[] { message, isSuccess });
            }
            else
            {
                // Update the statusBar directly if on the UI thread
                if (parentForm != null && parentForm.statusBar != null)
                {
                    parentForm.statusBar.Text = message;
                    parentForm.statusBar.ForeColor = isSuccess ? Color.Green : Color.Red;
                }
            }
        }


        




        protected override void DefWndProc(ref Message m)
        {
            switch (m.Msg)
            {
                case MESSAGE_CAPTURED_OK:
                    {
                        parentForm.statusBar.Visible = false;
                        DisplayFingerPrintImage();

                        if (IsRegister)
                        {
                            #region -------- IF REGISTERED FINGERPRINT --------
                            int ret = zkfp.ZKFP_ERR_OK;
                            int fid = 0, score = 0;
                            ret = fpInstance.Identify(CapTmp, ref fid, ref score);
                            if (zkfp.ZKFP_ERR_OK == ret)
                            {
                                int deleteCode = fpInstance.DelRegTemplate(fid);   // <---- REMOVE FINGERPRINT
                                if (deleteCode != zkfp.ZKFP_ERR_OK)
                                {
                                    DisplayMessage(MessageManager.msg_FP_CurrentFingerAlreadyRegistered + fid, false);
                                    return;
                                }
                            }
                            if (RegisterCount > 0 && fpInstance.Match(CapTmp, RegTmps[RegisterCount - 1]) <= 0)
                            {
                                DisplayMessage("Please press the same finger " + REGISTER_FINGER_COUNT + " times for enrollment", true);
                                return;
                            }
                            Array.Copy(CapTmp, RegTmps[RegisterCount], cbCapTmp);

                            if (RegisterCount == 0) btnEnroll.Enabled = true;
                            

                            RegisterCount++;
                            if (RegisterCount >= REGISTER_FINGER_COUNT)
                            {
                                RegisterCount = 0;
                                ret = GenerateRegisteredFingerPrint();   // <--- GENERATE FINGERPRINT TEMPLATE
                                
                            }
                            else
                            {
                                int remainingCont = REGISTER_FINGER_COUNT - RegisterCount;
                               // lblFingerPrintCount.Text = remainingCont.ToString();
                                string message = "Please provide your fingerprint " + remainingCont + " more time(s)";
                                DisplayMessage(message, true);
                            }
                            #endregion
                        }
                        else
                        {

                            Task.Run(async () =>
                            {
                                try
                                {
                                    await MatchFingerprintAsync(CapTmp);
                                }
                                catch (Exception ex)
                                {
                                    UpdateUI(() => DisplayMessage($"Unexpected error: {ex.Message}", false));
                                }
                            });
                        }
                    }
                    break;

                default:
                    base.DefWndProc(ref m);
                    break;
            }
        }


        private async Task MatchFingerprintAsync(byte[] capturedTemplate)
        {
            string query = "SELECT user_id, template FROM user_fingerprint";

            try
            {
                using (MySqlConnection connection = new MySqlConnection(connectionString))
                {
                    await connection.OpenAsync();
                    using (MySqlCommand command = new MySqlCommand(query, connection))
                    {
                        using (DbDataReader reader = await command.ExecuteReaderAsync())
                        {
                            bool matchFound = false;
                            string matchedUserId = string.Empty;

                            while (await reader.ReadAsync())
                            {
                                var mySqlReader = (MySqlDataReader)reader;

                                string userId = mySqlReader["user_id"].ToString();
                                string base64Template = mySqlReader["template"].ToString();

                                byte[] dbTemplate = Convert.FromBase64String(base64Template);

                                // Compare the captured template with the database template
                                int matchScore = fpInstance.Match(capturedTemplate, dbTemplate);

                                if (matchScore > 0)
                                {
                                    matchFound = true;
                                    matchedUserId = userId;
                                    break; // Exit the loop once a match is found
                                }
                            }

                            if (matchFound)
                            {
                                DisplayMessage($"Fingerprint matched! User ID: {matchedUserId}", true);

                                // Get today's date
                                string today = DateTime.Now.ToString("yyyy-MM-dd");

                                // Check if attendance exists for this user today using a new connection
                                string attendanceQuery = "SELECT * FROM attendances WHERE user_id = @userId AND date = @today";

                                using (MySqlConnection attConnection = new MySqlConnection(connectionString))
                                {
                                    await attConnection.OpenAsync();

                                    using (MySqlCommand attCmd = new MySqlCommand(attendanceQuery, attConnection))
                                    {
                                        attCmd.Parameters.AddWithValue("@userId", matchedUserId);
                                        attCmd.Parameters.AddWithValue("@today", today);

                                        using (DbDataReader attReader = await attCmd.ExecuteReaderAsync())
                                        {
                                            if (await attReader.ReadAsync())
                                            {
                                                // Update existing attendance record based on which time part it is
                                                string timeInAm = attReader["punch_in_am_first"].ToString();
                                                string timeOutAm = attReader["punch_in_am_second"].ToString();
                                                string timeInPm = attReader["punch_in_pm_first"].ToString();
                                                string timeOutPm = attReader["punch_in_pm_second"].ToString();

                                                if (string.IsNullOrEmpty(timeInAm))
                                                {
                                                    // Update TimeIn_AM if not already set
                                                    await UpdateAttendanceTimeAsync(matchedUserId, today, "punch_in_am_first", DateTime.Now);
                                                }
                                                else if (string.IsNullOrEmpty(timeOutAm))
                                                {
                                                    // Update Timeout_AM if not set yet
                                                    await UpdateAttendanceTimeAsync(matchedUserId, today, "punch_in_am_second", DateTime.Now);
                                                }
                                                else if (string.IsNullOrEmpty(timeInPm))
                                                {
                                                    // Update TimeIn_PM if not yet set
                                                    await UpdateAttendanceTimeAsync(matchedUserId, today, "punch_in_pm_first", DateTime.Now);
                                                }
                                                else if (string.IsNullOrEmpty(timeOutPm))
                                                {
                                                    // Update Timeout_PM if not yet set
                                                    await UpdateAttendanceTimeAsync(matchedUserId, today, "punch_in_pm_second", DateTime.Now);
                                                }
                                            }
                                            else
                                            {
                                                // No existing attendance, insert a new record with TimeIn_AM
                                                await InsertAttendanceAsync(matchedUserId, today, DateTime.Now);
                                            }
                                        }
                                    }
                                }
                            }
                            else
                            {
                                DisplayMessage("No matching fingerprint found in the database.", false);
                            }
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                DisplayMessage($"Database error: {ex.Message}", false);
            }
        }

        private async Task InsertAttendanceAsync(string userId, string date, DateTime timeInAm)
        {
            try
            {
                // Step 1: Insert attendance record
                string insertQuery = "INSERT INTO attendances (user_id , date, punch_in_am_first) VALUES (@userId, @date, @timeInAm)";

                using (MySqlConnection connection = new MySqlConnection(connectionString))
                {
                    await connection.OpenAsync();

                    using (MySqlCommand insertCmd = new MySqlCommand(insertQuery, connection))
                    {
                        insertCmd.Parameters.AddWithValue("@userId", userId);
                        insertCmd.Parameters.AddWithValue("@date", date);
                        insertCmd.Parameters.AddWithValue("@timeInAm", timeInAm);

                        await insertCmd.ExecuteNonQueryAsync();
                    }
                }

                // Step 2: Retrieve user name and last name
                string selectQuery = "SELECT name, lastname FROM users WHERE custom_id = @userId";

                using (MySqlConnection connection = new MySqlConnection(connectionString))
                {
                    await connection.OpenAsync();

                    using (MySqlCommand selectCmd = new MySqlCommand(selectQuery, connection))
                    {
                        selectCmd.Parameters.AddWithValue("@userId", userId);

                        using (MySqlDataReader reader = (MySqlDataReader)await selectCmd.ExecuteReaderAsync())
                        {
                            if (await reader.ReadAsync())
                            {
                                string firstName = reader["name"].ToString();
                                string lastName = reader["lastname"].ToString();

                                // Combine name and last name for display
                                string fullName = $"{firstName} {lastName}";

                                // Use Invoke to update label5 on the UI thread
                                if (label5.InvokeRequired)
                                {
                                    label5.Invoke(new Action(() =>
                                    {
                                        label5.Text = "Last login: " + fullName;
                                    }));
                                }
                                else
                                {
                                    
                                    label5.Text = fullName;
                                }
                            }
                            else
                            {
                                DisplayMessage("User not found.", false);
                            }
                        }
                    }
                }

                // Display success message
                DisplayMessage("Attendance recorded: Punch in AM", true);
            }
            catch (Exception ex)
            {
                DisplayMessage($"Error inserting attendance: {ex.Message}", false);
            }
        }

        private async Task UpdateAttendanceTimeAsync(string userId, string date, string columnName, DateTime time)
        {
            try
            {
                string updateQuery = $"UPDATE attendances SET {columnName} = @time WHERE user_id = @userId AND date = @date";

                using (MySqlConnection connection = new MySqlConnection(connectionString))
                {
                    await connection.OpenAsync();
                    using (MySqlCommand updateCmd = new MySqlCommand(updateQuery, connection))
                    {
                        updateCmd.Parameters.AddWithValue("@time", time);
                        updateCmd.Parameters.AddWithValue("@userId", userId);
                        updateCmd.Parameters.AddWithValue("@date", date);

                        await updateCmd.ExecuteNonQueryAsync();
                    }
                }
                // Step 2: Retrieve user name and last name
                string selectQuery = "SELECT name, lastname FROM users WHERE custom_id = @userId";

                using (MySqlConnection connection = new MySqlConnection(connectionString))
                {
                    await connection.OpenAsync();

                    using (MySqlCommand selectCmd = new MySqlCommand(selectQuery, connection))
                    {
                        selectCmd.Parameters.AddWithValue("@userId", userId);

                        using (MySqlDataReader reader = (MySqlDataReader)await selectCmd.ExecuteReaderAsync())
                        {
                            if (await reader.ReadAsync())
                            {
                                string firstName = reader["name"].ToString();
                                string lastName = reader["lastname"].ToString();

                                // Combine name and last name for display
                                string fullName = $"{firstName} {lastName}";

                                // Use Invoke to update label5 on the UI thread
                                if (label5.InvokeRequired)
                                {
                                    label5.Invoke(new Action(() =>
                                    {
                                        label5.Text = "Last login: " + fullName;
                                    }));
                                }
                                else
                                {
                                    label5.Text = fullName;
                                }
                            }
                            else
                            {
                                DisplayMessage("User not found.", false);
                            }
                        }
                    }
                }

                DisplayMessage($"Attendance updated: {columnName.Replace("_", " ").ToUpper()}", true);
            }
            catch (Exception ex)
            {
                DisplayMessage($"Error updating attendance: {ex.Message}", false);
            }
        }











        /// <summary>
        /// FREE RESOURCES
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void bnFree_Click(object sender, EventArgs e)
        {
            int result = fpInstance.Finalize();

            if (result == zkfp.ZKFP_ERR_OK)
            {
                DisconnectFingerPrintCounter();
                IsRegister = false;
                RegisterCount = 0;
                regTempLen = 0;
                ClearImage();
                cmbIdx.Items.Clear();
                Utilities.EnableControls(true, btnInit);
                //     Utilities.EnableControls(false, btnFree, btnClose, btnEnroll, btnVerify, btnIdentify);

                DisplayMessage("Resources were successfully released from the memory !!", true);
            }
            else
                DisplayMessage("Failed to release the resources !!", false);
        }

        private void ClearImage()
        {
            picFPImg.Image = null;
            //pbxImage2.Image = null;
        }

        private void bnEnroll_Click(object sender, EventArgs e)
        {
            ClearImage();
            textBox1.Text = null;
            IsRegister = false;
            label5.Text = "Last login: ";
            panel2.Visible = true;
            label5.Visible = false;
        }





        public object PushToDevice(object args)
        {
            DisplayMessage("Pushed to fingerprint !", true);
            return null;
        }


        public void ReEnrollUser(bool enableEnroll, bool clearDeviceUser = true)
        {
            ClearImage();
            if (clearDeviceUser && !btnInit.Enabled) ClearDeviceUser();
            if (enableEnroll) btnEnroll.Enabled = true;
        }


        public void ClearDeviceUser()
        {
            try
            {
                int deleteCode = fpInstance.DelRegTemplate(iFid);   // <---- REMOVE FINGERPRINT
                if (deleteCode != zkfp.ZKFP_ERR_OK)
                {
                    DisplayMessage(MessageManager.msg_FP_UnableToDeleteFingerPrint + iFid, false);
                }
                iFid = 1;
            }
            catch { }

        }


        public bool ReleaseResources()
        {
            try
            {
                ReEnrollUser(true, true);
                bnClose_Click(null, null);
                return true;
            }
            catch
            {
                return false;
            }

        }

        #region -------- CONNECT/DISCONNECT DEVICE --------



        /// <summary>
        /// DISCONNECT DEVICE
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void bnClose_Click(object sender, EventArgs e)
        {
            OnDisconnect();
            label5.Text = "Employee Name: ";
            textBox1.Text = null;
            panel1.Visible = false;
            panel2.Visible = false;
            label5.Visible = false;
            Utilities.EnableControls(false, btnEnroll);
        }


        public void OnDisconnect()
        {
            bIsTimeToDie = true;
            RegisterCount = 0;
            DisconnectFingerPrintCounter();
            ClearImage();
            Thread.Sleep(1000);
            int result = fpInstance.CloseDevice();

            captureThread.Abort();
            if (result == zkfp.ZKFP_ERR_OK)
            {
                //     Utilities.EnableControls(false, btnInit, btnClose, btnEnroll, btnVerify, btnIdentify);

                lblDeviceStatus.Text = Disconnected;

                Thread.Sleep(1000);
                result = fpInstance.Finalize();   // CLEAR RESOURCES

                if (result == zkfp.ZKFP_ERR_OK)
                {
                    regTempLen = 0;
                    IsRegister = false;
                    cmbIdx.Items.Clear();
                    Utilities.EnableControls(true, btnInit);
                    //    Utilities.EnableControls(false, btnClose, btnEnroll, btnVerify, btnIdentify);

                    ReInitializeInstance();

                    DisplayMessage(MessageManager.msg_FP_Disconnected, true);
                }
                else
                    DisplayMessage(MessageManager.msg_FP_FailedToReleaseResources, false);


            }
            else
            {
                string errorMessage = FingerPrintDeviceUtilities.DisplayDeviceErrorByCode(result);
                DisplayMessage(errorMessage, false);
            }
        }


        #endregion



        #region ------- COMMON --------

        private void FingerPrintControl_Load(object sender, EventArgs e) { FormHandle = this.Handle; }

        private void ReInitializeInstance()
        {
            Utilities.EnableControls(true, btnInit);
            //  Utilities.EnableControls(false, btnClose, btnEnroll, btnVerify, btnIdentify);
            DisconnectFingerPrintCounter();
           
            //  btnVerify.Text = VerifyButtonDefault;
        }

        private void DisconnectFingerPrintCounter()
        {
           // lblFingerPrintCount.Text = REGISTER_FINGER_COUNT.ToString();
           // lblFingerPrintCount.Visible = false;
        }

        #endregion


        #region -------- UTILITIES --------


        /// <summary>
        /// Combines Three Pre-Registered Fingerprint Templates as One Registered Fingerprint Template
        /// </summary>
        /// <returns></returns>
        private int GenerateRegisteredFingerPrint()
        {
            // Ensure the fingerprint templates are available
            if (RegTmps[0] == null)
            {
                Console.WriteLine("Error: Fingerprint template is not available.");
                return zkfp.ZKFP_ERR_INVALID_PARAM;
            }

            // Generate the registration template using the available fingerprint templates
            int result = fpInstance.GenerateRegTemplate(RegTmps[0], RegTmps[0], RegTmps[0], RegTmp, ref regTempLen);

            // Check if the template generation was successful
            if (result != zkfp.ZKFP_ERR_OK)
            {
                Console.WriteLine("Error generating registration template.");
                return result;  // Return the error code from GenerateRegTemplate
            }

            // Now add the generated template to the database (assuming ID = 1 here for illustration)
            result = fpInstance.AddRegTemplate(iFid, RegTmp);

            // Check if adding the template was successful
            if (result != zkfp.ZKFP_ERR_OK)
            {
                Console.WriteLine("Error adding registration template.");
                return result;  // Return the error code from AddRegTemplate
            }

            // Success: Fingerprint registered successfully
            Console.WriteLine($"Fingerprint registered successfully with ID: {iFid}");

            // Now call your save method to save the fingerprint template to the database
            saveFingerPrintToDatabaseAsync();
            
            IsRegister = false;

            return zkfp.ZKFP_ERR_OK;
        }

        private async void saveFingerPrintToDatabaseAsync()
        {
            try
            {
                string userId = textBox1.Text.Trim();

                if (string.IsNullOrEmpty(userId))
                {
                    DisplayMessage("User ID is required.", false);
                    return;
                }

                // Convert the fingerprint template to a base64 string before saving it
                string fingerPrintTemplate = string.Empty;
                zkfp.Blob2Base64String(RegTmp, regTempLen, ref fingerPrintTemplate);


                // Use Task.Run to run the database operation on a separate thread
                await Task.Run(() =>
                {
                    try
                    {
                        // Set up the connection to your database
                        using (MySqlConnection conn = new MySqlConnection(connectionString))
                        {
                            // Open the connection
                            conn.Open();

                            // Create the query to insert the fingerprint template into the database
                            string query = "INSERT INTO user_fingerprint (user_id, template, status, created_at) VALUES (@user_id, @template, @status, @created_at)";

                            // Create the command with the query and the parameters
                            using (MySqlCommand cmd = new MySqlCommand(query, conn))
                            {
                                cmd.Parameters.AddWithValue("@user_id", userId);  // Use the userId from textBox1
                                cmd.Parameters.AddWithValue("@template", fingerPrintTemplate);  // Using the base64 template
                                cmd.Parameters.AddWithValue("@status", "active");  // Assuming "active" is the status
                                cmd.Parameters.AddWithValue("@created_at", DateTime.Now);  // Assuming current time for created_at

                                // Execute the command
                                cmd.ExecuteNonQuery();
                            }
                        }

                        // Notify the user that the fingerprint was saved successfully
                        this.Invoke(new Action(() =>
                        {
                            DisplayMessage("Fingerprint saved successfully!", true);
                            textBox1.Text = null;
                            
                            panel1.Visible = false;
                            label5.Visible = true;
                            
                            ClearImage();
                        }));
                    }
                    catch (Exception ex)
                    {
                        // Handle any errors
                        this.Invoke(new Action(() =>
                        {
                            DisplayMessage("Error saving fingerprint: " + ex.Message, false);
                        }));
                    }
                });
            }
            catch (Exception ex)
            {
                // Handle any errors
                DisplayMessage("Error initiating database operation: " + ex.Message, false);
            }
        }



        /// <summary>
        /// Add A Registered Fingerprint Template To Memory | params: (FingerPrint ID, Registered Template)
        /// </summary>
        /// <returns></returns>
        private int AddTemplateToMemory()
        {
            return fpInstance.AddRegTemplate(iFid, RegTmp);
        }




        private void DisplayFingerPrintImage()
        {
            // OPTIMIZED METHOD
            MemoryStream ms = new MemoryStream();
            BitmapFormat.GetBitmap(FPBuffer, mfpWidth, mfpHeight, ref ms);
            Bitmap bmp = new Bitmap(ms);
            this.picFPImg.Image = bmp;

        }

        private void DisplayMessage(string message, bool normalMessage)
        {
            try
            {
                Utilities.ShowStatusBar(message, parentForm.statusBar, normalMessage);
            }
            catch (Exception ex)
            {
                Utilities.ShowStatusBar(ex.Message, parentForm.statusBar, false);
            }
        }



        #endregion






        private void UpdateUI(Action action)
        {
            if (InvokeRequired)
            {
                Invoke(action);
            }
            else
            {
                action();
            }
        }

        private void button1_Click(object sender, EventArgs e)
        {
          //  ClearImage();

            string customId = textBox2.Text;
            string password = textBox3.Text;

            // SQL query to fetch the user's password and user_type
            string query = "SELECT password, user_type FROM users WHERE custom_id = @customId";

            using (var connection = new MySqlConnection(connectionString))
            {
                try
                {
                    connection.Open();
                    MySqlCommand cmd = new MySqlCommand(query, connection);
                    cmd.Parameters.AddWithValue("@customId", customId);

                    using (var reader = cmd.ExecuteReader())
                    {
                        if (reader.Read())
                        {
                            string storedPasswordHash = reader["password"].ToString();
                            int userType = Convert.ToInt32(reader["user_type"]);

                            // Verify the password using BCrypt
                            if (BCrypt.Net.BCrypt.Verify(password, storedPasswordHash))
                            {
                                // Login success: Check if the user is a regular user (user_type = 0)
                                if (userType == 0)
                                {
                                    // Proceed with fingerprint registration
                                    if (!IsRegister)
                                    {
                                        panel2.Visible = false;

                                        IsRegister = true;
                                        RegisterCount = 0;
                                        regTempLen = 0;
                                        panel1.Visible = true;

                                        DisplayMessage("Please press your finger " + REGISTER_FINGER_COUNT + " times to register", true);

                                        //lblFingerPrintCount.Visible = true;
                                       // lblFingerPrintCount.Text = REGISTER_FINGER_COUNT.ToString();

                                        textBox2.Text = null;
                                        textBox3.Text = null;
                                    }
                                }
                                else
                                {
                                    DisplayMessage("User is not authorized for this action.", false);
                                }
                            }
                            else
                            {
                                DisplayMessage("Incorrect password. Please try again.", false);
                            }
                        }
                        else
                        {
                            DisplayMessage("User not found.", false);
                        }
                    }
                }
                catch (Exception ex)
                {
                    DisplayMessage("Error: " + ex.Message, false);
                }
            }
        }

        private void label5_Click(object sender, EventArgs e)
        {

        }
    }
}
