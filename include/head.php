<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Use the Play CDN to try Tailwind right in the browser without any build step. The Play CDN is designed for development purposes only, and is not the best choice for production. -->
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Ox Corp - <?php echo $headTitle ?></title>

    <style>
        .btn {
            max-width: 200px;
            width: fit-content;
            border: 2px solid dodgerblue;
            padding: 3px 16px;
            cursor: pointer;
            border-radius: 60px;
        }

        .btn:hover {
            background-color: dodgerblue;
            color: white;
            font-weight: 600;
        }
    </style>

</head>