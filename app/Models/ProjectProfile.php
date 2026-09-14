<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ProjectProfile extends Model {
    protected $fillable = ['name', 'headline', 'school', 'major', 'skills', 'bio', 'email', 'github_url', 'website_url', 'photo'];
}
