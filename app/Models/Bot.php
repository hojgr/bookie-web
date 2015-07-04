<?php
/**
 * Bot
 *
 * PHP version 5.6
 *
 * @category Class
 * @package  BookieGG\Models
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */

namespace BookieGG\Models;

use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    protected $fillable = ['steam_id', 'display_name'];
}
