<?php
// app/Models/File.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'path', 'mime_type', 'size'];

    public function fileable()
    {
        return $this->morphTo();
    }
}
