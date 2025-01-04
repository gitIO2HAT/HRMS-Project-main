namespace ZKTecoFingerPrintScanner_Implementation.Controls
{
    partial class MatchFingerPrint
    {
        /// <summary> 
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary> 
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Component Designer generated code

        /// <summary> 
        /// Required method for Designer support - do not modify 
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.picFPImg2 = new System.Windows.Forms.PictureBox();
            this.textBox2 = new System.Windows.Forms.TextBox();
            ((System.ComponentModel.ISupportInitialize)(this.picFPImg2)).BeginInit();
            this.SuspendLayout();
            // 
            // picFPImg2
            // 
            this.picFPImg2.BackColor = System.Drawing.Color.Transparent;
            this.picFPImg2.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.picFPImg2.Location = new System.Drawing.Point(101, 59);
            this.picFPImg2.Name = "picFPImg2";
            this.picFPImg2.Size = new System.Drawing.Size(125, 129);
            this.picFPImg2.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
            this.picFPImg2.TabIndex = 780;
            this.picFPImg2.TabStop = false;
            // 
            // textBox2
            // 
            this.textBox2.Location = new System.Drawing.Point(101, 244);
            this.textBox2.Name = "textBox2";
            this.textBox2.Size = new System.Drawing.Size(100, 22);
            this.textBox2.TabIndex = 781;
            // 
            // MatchFingerPrint
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(8F, 16F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.Controls.Add(this.textBox2);
            this.Controls.Add(this.picFPImg2);
            this.Name = "MatchFingerPrint";
            this.Size = new System.Drawing.Size(390, 373);
            ((System.ComponentModel.ISupportInitialize)(this.picFPImg2)).EndInit();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.PictureBox picFPImg2;
        private System.Windows.Forms.TextBox textBox2;
    }
}
