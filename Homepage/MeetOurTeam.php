<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meet Our Team - Kupi Coffee</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color:rgb(249, 223, 239);
            margin: 0;
            padding: 70px;
        }

        .team-section {
            text-align: center;
            padding: 50px 20px;
        }

        .team-section h1 {
            font-size: 36px;
            color: #7a2005;
            margin-bottom: 20px;
        }

        .team-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            padding: 20px;
        }

        .team-card {
            background-color: #ffffff;
            border-radius: 10px;
            width: 250px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .team-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .team-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .team-card h3 {
            font-size: 20px;
            color: #7a2005;
            margin: 10px 0 5px;
        }

        .team-card p {
            font-size: 16px;
            color: #555555;
            margin: 0 0 15px;
        }

        .social-icons {
            margin-bottom: 15px;
        }

        .social-icons a {
            color: #7a2005;
            font-size: 18px;
            margin: 0 5px;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: #FFD700;
        }

        #btn {
        display: inline-block;
        margin-top: 20px; /* Adds spacing from the team grid */
        padding: 10px 20px;
        font-size: 18px;
        font-weight: bold;
        color: #ffffff;
        background-color: rgb(255, 102, 173);
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    #btn:hover {
        background-color: rgb(153, 0, 71);
        transform: scale(1.1);
    }

    #btn:focus {
        outline: none;
    }

    </style>
    <section class="team-section">
        <h1 style="font-size: 60px; font-weight: bold; color:rgb(255, 102, 173); margin-top: 15px;">Meet Our Team</h1>
        <p style="font-size: 20px; font-weight: bold; color:rgb(153, 0, 71);">Get to know the passionate individuals who make every cup of Kupi Coffee unforgettable.</p>
        <div class="team-grid">

        <!-- Team Member Cards -->
        <div class="team-card">
            <img src="../image/staff1.jpg" alt="Staff Member">
            <h3 style="font-weight: bold;">ZAHIN EIFWWAT</h3>
            <p>Store Manager</p>
            <div class="social-icons">
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </div>

            <!-- Team Member 2 -->
            <div class="team-card">
                <img src="../image/staff2.jpg" alt="Staff Member">
                <h3 style="font-weight: bold;">SHARIFAH NUR AIN</h3>
                <p>Head Barista</p>
                <div class="social-icons">
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>

            <!-- Team Member 3 -->
            <div class="team-card">
                <img src="../image/staff3.jpg" alt="Staff Member">
                <h3 style="font-weight: bold;">ASYRAF HAZIQ</h3>
                <p>Supervisor</p>
                <div class="social-icons">
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>

            <!-- Team Member 4 -->
            <div class="team-card">
                <img src="../image/staff4.jpg" alt="Staff Member">
                <h3 style="font-weight: bold;">RINA KARTIKA</h3>
                <p>Latte Artist</p>
                <div class="social-icons">
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>

            <!-- Team Member 5 -->
            <div class="team-card">
                <img src="../image/staff5.jpg" alt="Staff Member">
                <h3 style="font-weight: bold;">WAFIUDDIN</h3>
                <p>Marketing Specialist</p>
                <div class="social-icons">
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>

        </div>

        <div style="text-align: center; margin-top: 30px;">
        <button onclick="window.location.href='index.php';" type="button" id="btn">Back</button>
    </div>
        
    </section>

</html>
