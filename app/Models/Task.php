<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'due_date', 'status', 'user_id', 'attachment',
    ];

    // Define the file upload directory
    protected $uploadDirectory = 'attachments';

    // Method to handle file upload
    public function uploadAttachment($file)
    {
        // Generate a unique file name
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

        // Store the file in the specified directory
        $file->storeAs($this->uploadDirectory, $fileName);

        // Return the file path
        return $fileName;
    }

    // Method to get the full attachment URL
    public function getAttachmentUrl()
    {
        // Check if attachment exists
        if ($this->attachment) {
            // Generate the full URL for the attachment
            return Storage::url($this->uploadDirectory . '/' . $this->attachment);
        }

        return null;
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Define the relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
