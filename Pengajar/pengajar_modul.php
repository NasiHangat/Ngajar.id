<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Ngajar.ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/warna.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;300;400;500;600;700;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        roboto: ['"Roboto Slab"', 'serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white-50 font-roboto">
    <div class="flex flex-col min-h-screen">
        <header class="bg-white shadow-sm sticky top-0 z-30">
            <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button id="hamburgerButton" class="text-ngajar-green focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-xl font-bold text-ngajar-green hidden sm:block">My Class</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-ngajar-green hover:opacity-75 p-2">
                        <i class="fas fa-bell text-xl"></i>
                    </button>
                    <button class="text-ngajar-green hover:opacity-75 p-2">
                        <i class="fas fa-envelope text-xl"></i>
                    </button>
                    <button class="text-ngajar-green hover:opacity-75 p-2">
                        <i class="fas fa-user text-xl"></i>
                    </button>
                </div>
            </div>
        </header>
        <?php include "../Includes/sidebar.php" ?>;
    </div>
</body>
</html>