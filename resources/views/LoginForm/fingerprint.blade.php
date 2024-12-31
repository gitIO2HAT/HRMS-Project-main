<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jhon Mark Egos - Portfolio</title>
    <link rel="icon" href="picture.png" type="image/png">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="style.css">
</head>
<style>
    body {
        margin-left: 10px;
        margin-right: 10px;
        padding-top: 100px;
        background-image: url('img/BG.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        /* Ensures background stays fixed while content scrolls */
    }

    .header-custom {
        height: 100px;
        font-size: 30px;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        background-color: rgba(235, 229, 229, 0.288);
        backdrop-filter: blur(2px);
        -webkit-backdrop-filter: blur(2px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.3);
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgb(170, 168, 168);
        border-radius: 50%;
        width: 50px;
        height: 50px;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-size: 100%, 100%;
    }

    .custom-text {
        text-decoration: none;
        color: rgb(7, 7, 7);

    }

    .custom-text:hover {
        color: aqua;

    }

    .name {
        font-size: 100px;
        font-family: 'Poppins', sans-serif;
    }

    .aboutme {
        font-size: 25px;
        text-align: justify;
        font-family: 'Montserrat Classic', sans-serif;
    }

    .hobbiesInterest {
        font-size: 30px;
        font-family: 'Poppins', sans-serif;
    }

    .list {
        font-size: 25px;
        font-family: 'Montserrat Classic', sans-serif;
    }

    .contact {
        color: #542c5c;
        font-size: 25px;
        font-family: 'Poppins', sans-serif;
        text-decoration: none;
    }

    .expercience {
        font-size: 25px;
        font-family: 'Montserrat Classic', sans-serif;
        padding-left: 100px;
        padding-right: 100px;
        margin-top: 400px;

    }

    .details {
        font-size: 25px;
        text-align: justify;
        font-family: 'Montserrat Classic', sans-serif;
    }

    .info a {
        text-decoration: none;


    }

    .info {
        margin-top: 180px;
        margin-bottom: 180px;
    }

    .technician a {
        text-decoration: none;
    }
</style>

<body id="Home" class=".container-xxl">

    <header class="header-custom d-flex justify-content-between align-items-end px-5">
        <div class="text-start">
            <h1 class="text-white" id="visited-name"></h1>
        </div>
        <div class="pb-3">
            <a class="custom-text mx-2" href="#Home">Home</a>
            <a class="custom-text mx-2" href="#Aboutme">About Me</a>
            <a class="custom-text mx-2" href="#Certificates">Certificates</a>
            <a class="custom-text mx-2" href="#Services">Services</a>
            <a class="custom-text mx-2" href="{{ url('/LoginUser') }}">login</a>
        </div>
    </header>

    <div class=" row mt-5 ">

        <div id="Aboutme" class="row col-12 col-sm-12 col-xl-8 text-dark text-center">
            <div class="col-6 col-sm-6 col-xl-6 px-2">
                <h3 class="text-start">January 1, 2025</h3>
            </div>
            <div class="col-6 col-sm-6 col-xl-6 px-2">
                <h3 class="text-end">08:00 AM</h3>
            </div>

            <table class="table text-center mx-2 border border-dark rounded-3" style="background-color: transparent;">
                <tbody>
                    <tr>
                        <th scope="row" class="text-center" style="border: none; background-color: transparent; color: black;">Name</th>
                        <td style="border: none; background-color: transparent; color: black;">{{$firstRecord->user_id}}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center" style="border: none; background-color: transparent; color: black;">Department</th>
                        <td style="border: none; background-color: transparent; color: black;">{{$firstRecord->user->department}}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center" style="border: none; background-color: transparent; color: black;">Position</th>
                        <td style="border: none; background-color: transparent; color: black;">{{$firstRecord->user->position}}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center" style="border: none; background-color: transparent; color: black;">Time-in AM</th>
                        <td style="border: none; background-color: transparent; color: black;">08:00 AM</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center" style="border: none; background-color: transparent; color: black;">Time-out AM</th>
                        <td style="border: none; background-color: transparent; color: black;">12:00 PM</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center" style="border: none; background-color: transparent; color: black;">Time-in PM</th>
                        <td style="border: none; background-color: transparent; color: black;">01:00 PM</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center" style="border: none; background-color: transparent; color: black;">Time-out PM</th>
                        <td style="border: none; background-color: transparent; color: black;">05:00 PM</td>
                    </tr>
                </tbody>
            </table>

            <table class="table text-center mx-2 border border-dark rounded-3" style="background-color: transparent;">
                <Thead>
                    <tr>
                        <th>Name</th>
                        <th>Time</th>
                    </tr>
                </Thead>
                <tbody>
                    <tr>
                        <td style="border: none; background-color: transparent; color: black;">John Doe</td>
                        <td style="border: none; background-color: transparent; color: black;">John Doe</td>
                    </tr>   
                </tbody>
            </table>

        </div>

        <div class="col-12 col-sm-12 col-xl-4  text-center align-content-center">
            <img src="img/user.png" alt="Profile Picture" class="shadow img-fluid rounded-circle mb-3"
                style="width: 300px; height: 300px;">
        </div>


    </div>






    <!-- Example of Font Awesome icons -->

    </div>
    <!-- Bootstrap 5 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>

    <script src="script.js"></script>
</body>

</html>