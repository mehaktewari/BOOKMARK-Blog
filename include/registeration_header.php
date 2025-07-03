<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-image: url('./assets/logo/picture 2.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 450px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #fff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-group input, .input-group select, .input-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: none;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
        }

        .input-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .input-group input:focus, 
        .input-group select:focus,
        .input-group textarea:focus {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .input-group label {
            position: absolute;
            top: -10px;
            left: 15px;
            background: rgba(255, 255, 255, 0.8);
            padding: 0 5px;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: #4a6bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: #3a56d4;
            transform: translateY(-2px);
        }

        .status-options {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .status-option {
            flex: 1;
            text-align: center;
            margin: 0 5px;
        }

        .status-option input {
            display: none;
        }

        .status-option label {
            display: block;
            padding: 10px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .status-option input:checked + label {
            background: #4a6bff;
            color: white;
        }
    </style>
</head>