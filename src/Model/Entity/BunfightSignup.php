<?php

namespace SUSC\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * BunfightSignup Entity
 *
 * @property string $id
 * @property string $bunfight_id
 * @property string $first_name
 * @property string $last_name
 * @property string $full_name
 * @property string $email_address
 * @property string $gender
 * @property string $ability
 * @property int $graduation_year
 * @property string[] $squad_ids
 * @property string $bunfight_session_id
 * @property bool $consent_to_emails
 * @property string $unsubscribeUri
 * @property string[] $squad_names
 *
 * @property Squad[] $squads
 * @property Bunfight $bunfight
 * @property BunfightSession $bunfight_session
 */
class BunfightSignup extends Entity
{

    public static $genders = [
        'f' => 'Female',
        'm' => 'Male'
    ];
    public static $abilities = [
        '-' => 'Can’t Swim',
        'l' => 'Swimming Lessons',
        'b' => 'Club',
        'c' => 'County',
        'r' => 'Regional',
        'n' => 'National',
        'i' => 'International'
    ];

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'first_name' => true,
        'last_name' => true,
        'email_address' => true,
        'graduation_year' => true,
        'gender' => true,
        'ability' => true,
        'squad_id' => true,
        'bunfight_id' => true,
        'bunfight_session_id' => true,
        'consent_to_emails' => true,
        'squads' => true,
        'bunfight_session' => true
    ];

    protected function _getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    protected function _getUnsubscribeUri()
    {
        return Router::url(['controller' => 'Bunfight', 'action' => 'unsubscribe', '?' => ['email_address' => $this->email_address]], true);
    }

    protected function _getSquadNames()
    {
        $names = [];
        foreach ($this->squads as $s) {
            $names[] = $s->name;
        }
        return $names;
    }
}
