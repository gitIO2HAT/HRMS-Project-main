<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>HRMS - <?php echo e(Request::segment(2)); ?> - <?php echo e(Request::segment(3)); ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?php echo e(asset('lib/owlcarousel/assets/owl.carousel.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')); ?>" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
</head>

<body>

    <div class="container-fluid position-relative d-flex p-0 ">
        <!-- Spinner Start -->

        <!-- Spinner End -->

        <!-- sidebar-menu Start -->
        <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- sidebar-menu Start -->



        <div class="content">

            <!-- header Start -->
            <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- header end -->


            <!-- Dashboard Start -->
            <?php echo $__env->yieldContent('content'); ?>

            <!-- Dashboard end -->

        </div>

    </div>

    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo e(asset('lib/chart/chart.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/easing/easing.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/waypoints/waypoints.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/owlcarousel/owl.carousel.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/tempusdominus/js/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/tempusdominus/js/moment-timezone.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/main.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('javascript'); ?>
</body>
<script>
    function clearSearch() {
        document.getElementById('search').value = '';
        document.getElementById('from').value = '';
        document.getElementById('to').value = '';
        document.getElementById('leave_type').selectedIndex = 0;
        document.querySelector('form').submit();
    }
</script>
<script>
    function handleImageClick(event) {
        // Prevent the default behavior of the click event on the label
        event.preventDefault();

        // Trigger file input click when the image is clicked
        document.getElementById('profileImage').click();
    }

    function displayImage(input) {
        var reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('profilePicture').src = e.target.result;
        };

        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>








<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all checkboxes
        const checkboxes = document.querySelectorAll('input[name="selected_users[]"]');

        checkboxes.forEach(function(checkbox) {
            // Add event listener to each checkbox
            checkbox.addEventListener('change', function() {
                // Get the parent row of the checkbox
                const row = checkbox.closest('tr');

                // Toggle the 'selected-row' class based on checkbox status
                if (checkbox.checked) {
                    row.classList.add('selected-row');
                } else {
                    row.classList.remove('selected-row');
                }
            });

            // Add click event to the entire row to toggle checkbox state
            const row = checkbox.closest('tr');
            row.addEventListener('click', function() {
                checkbox.checked = !checkbox.checked;
                // Trigger change event manually
                checkbox.dispatchEvent(new Event('change'));
            });
        });
    });
</script>

<script>
    function setMinEndTime() {
        var startDateInput = document.getElementById("scheduled_date");
        var endDateInput = document.getElementById("scheduled_end");

        if (startDateInput.value) {
            endDateInput.min = startDateInput.value;
        }
    }
</script>
<script>
    document.getElementById('birth_date').addEventListener('change', function() {
        var birthDate = new Date(this.value);
        var today = new Date();
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        document.getElementById('age').value = age;
    });
</script>

<script>
    function toggleEdit(id) {
        var span = document.getElementById('editable-span-' + id);
        var input = document.getElementById('editable-input-' + id);

        if (span.style.display !== 'none') {
            // Hide the span and show the input
            span.style.display = 'none';
            input.style.display = 'inline';
            input.focus();
        } else {
            // Hide the input and show the span
            span.style.display = 'inline';
            input.style.display = 'none';
            span.innerText = input.value;
        }
    }
</script>


<script>
    document.querySelector('.increment').addEventListener('click', function(event) {
     event.preventDefault(); // Prevent form submission
     var quantityInput = document.getElementById('quantity');
     var currentValue = parseFloat(quantityInput.value);
     if (currentValue < quantityInput.max) {
         quantityInput.value = (currentValue + parseFloat(quantityInput.step)).toFixed(2);
     }
 });

 document.querySelector('.decrement').addEventListener('click', function(event) {
     event.preventDefault(); // Prevent form submission
     var quantityInput = document.getElementById('quantity');
     var currentValue = parseFloat(quantityInput.value);
     if (currentValue > quantityInput.min) {
         quantityInput.value = (currentValue - parseFloat(quantityInput.step)).toFixed(2);
     }
 });
 </script>

<script>
  function updateStatus(id, status) {
    console.log("Updating status for ID:", id, "with status:", status);
    const form = document.getElementById('statusForm' + id);
    if (!form) {
        console.error("Form not found for ID:", id);
        return;
    }
    console.log("Form found. Appending hidden input for status.");

    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'status';
    hiddenInput.value = status;
    form.appendChild(hiddenInput);

    console.log("Submitting form with status:", hiddenInput.value);
    form.submit();
}
</script>

<script>
    var ctx = document.getElementById('growthChart').getContext('2d');
    var growthChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($employeeData)); ?>, // years
            datasets: [{
                label: 'Number of Employees',
                data: <?php echo json_encode(array_values($employeeData)); ?>, // employee counts
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }, {
                label: 'Growth Rate (%)',
                data: <?php echo json_encode(array_values($growthRates)); ?>, // growth rates
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                type: 'line',
                yAxisID: 'growthRate'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value; // show employee count
                        }
                    }
                },
                growthRate: {
                    type: 'linear',
                    position: 'right',
                    ticks: {
                        callback: function(value) {
                            return value + '%'; // show percentage
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.employee-checkbox');
        const exportBtn = document.getElementById('export-btn');
        const selectAllBtn = document.getElementById('select-all');
        const deselectAllBtn = document.getElementById('deselect-all');

        function toggleButtons() {
            const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
            exportBtn.style.display = anyChecked ? 'inline-block' : 'none';
            selectAllBtn.style.display = 'inline-block';
            deselectAllBtn.style.display = 'inline-block';
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', toggleButtons);
        });

        selectAllBtn.addEventListener('click', function(event) {
            event.preventDefault();
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            toggleButtons();
        });

        deselectAllBtn.addEventListener('click', function(event) {
            event.preventDefault();
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            toggleButtons();
        });

        exportBtn.addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('export-form').submit();
        });
    });
</script>

</html>
<?php /**PATH C:\xampp\htdocs\HRMS-Project-main\resources\views/layouts/app.blade.php ENDPATH**/ ?>