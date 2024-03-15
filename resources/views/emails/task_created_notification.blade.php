<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Task Created</title>
</head>
<body>
    <h1>New Task Created</h1>
    
    <p>Hello {{ $task->user->name }},</p>
    
    <p>A new task has been created with the following details:</p>
    
    <ul>
        <li><strong>Title:</strong> {{ $task->title }}</li>
        <li><strong>Description:</strong> {{ $task->description }}</li>
        <li><strong>Due Date:</strong> {{ $task->due_date }}</li>
        <li><strong>Status:</strong> {{ $task->status }}</li>
    </ul>
    
    <p>You can view this task by logging into your account.</p>
    
    <p>Thank you,</p>
    <p>Your App Team</p>
</body>
</html>
