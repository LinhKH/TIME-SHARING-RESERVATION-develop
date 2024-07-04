<?php
namespace App\Bundle\UserBundle\Application;

final class UserManagePostCommand
{
    /**
     * @var string
     */
    public string $userType;

    /**
     * @var int
     */
    public int $organizationId;

    /**
     * @var bool
     */
    public bool $active;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $firstName;

    /**
     * @var string
     */
    public string $lastName;

    /**
     * @var string
     */
    public string $firstNameFurigana;

    /**
     * @var string
     */
    public string $lastNameFurigana;

    /**
     * @var array
     */
    public array $files;

    /**
     * @var string
     */
    public string $password;

    /**
     * @var string
     */
    public string $gender;

    /**
     * @var bool
     */
    public bool $isRequestNotification;

    /**
     * @var bool
     */
    public bool $isReceiveNewsletter;

    /**
     * @var array
     */
    public array $userRoles;

    /**
     * @var array
     */
    public array $userWorkingGroups;

    /**
     * @var string|null
     */
    public ?string $organizationName;

    /**
     * @param string $userType userType
     * @param int $organizationId organizationId
     * @param bool $active active
     * @param string $email email
     * @param string $firstName firstName
     * @param string $lastName lastName
     * @param string $firstNameFurigana firstNameFurigana
     * @param string $lastNameFurigana lastNameFurigana
     * @param array $files files
     * @param string $password password
     * @param string $gender gender
     * @param bool $isRequestNotification isRequestNotification
     * @param bool $isReceiveNewsletter isReceiveNewsletter
     * @param array $userRoles userRole
     * @param array $userWorkingGroups userWorkingGroups
     * @param string|null $organizationName organizationName
     */
    public function __construct(
        string $userType,
        int $organizationId ,
        bool $active,
        string $email,
        string $firstName,
        string $lastName,
        string $firstNameFurigana,
        string $lastNameFurigana,
        array $files,
        string $password,
        string $gender,
        bool $isRequestNotification,
        bool $isReceiveNewsletter,
        array $userRoles,
        array $userWorkingGroups,
        ?string $organizationName
    ){
        $this->organizationName = $organizationName;
        $this->userRoles = $userRoles;
        $this->userWorkingGroups = $userWorkingGroups;
        $this->isReceiveNewsletter = $isReceiveNewsletter;
        $this->isRequestNotification = $isRequestNotification;
        $this->gender = $gender;
        $this->password = $password;
        $this->files = $files;
        $this->lastNameFurigana = $lastNameFurigana;
        $this->firstNameFurigana = $firstNameFurigana;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->email = $email;
        $this->active = $active;
        $this->organizationId = $organizationId;
        $this->userType = $userType;
    }
}


