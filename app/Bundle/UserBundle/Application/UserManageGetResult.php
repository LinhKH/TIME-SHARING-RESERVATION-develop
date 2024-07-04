<?php
namespace App\Bundle\UserBundle\Application;

use \App\Bundle\Common\Application\PaginationResult;

final class UserManageGetResult
{
    /**
     * @var int
     */
    public int $userId;

    /**
     * @var string
     */
    public string $userType;

    /**
     * @var int
     */
    public int $organizationId;

    /**
     * @var string|null
     */
    public ?string $organizationName;

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
     * @var string[]
     */
    public array $userWorkingGroups;

    /**
     * @var string[]
     */
    public array $userRoles;

    /**
     * @var string
     */
    public ?string $registerDate;

    /**
     * @var string|null
     */
    public ?string $loginLastDate;

    /**
     * @param int $userId userId
     * @param string $userType userType
     * @param int $organizationId organizationId
     * @param string|null $organizationName organizationName
     * @param bool $active active
     * @param string $email email
     * @param string $firstName firstName
     * @param string $lastName lastName
     * @param string $firstNameFurigana firstNameFurigana
     * @param string $lastNameFurigana lastNameFurigana
     * @param array $files files
     * @param string $gender gender
     * @param bool $isRequestNotification isRequestNotification
     * @param bool $isReceiveNewsletter isReceiveNewsletter
     * @param string[] $userRoles userRole
     * @param string[] $userWorkingGroups userWorkingGroups
     * @param string|null $registerDate registerDate
     * @param string|null $loginLastDate loginLastDate
     */
    public function __construct(
        int $userId,
        string $userType,
        int $organizationId,
        ?string $organizationName,
        bool $active,
        string $email,
        string $firstName,
        string $lastName,
        string $firstNameFurigana,
        string $lastNameFurigana,
        array $files,
        string $gender,
        bool $isRequestNotification,
        bool $isReceiveNewsletter,
        array $userRoles,
        array $userWorkingGroups,
        ?string $registerDate,
        ?string $loginLastDate
    ) {
        $this->userRoles = $userRoles;
        $this->userWorkingGroups = $userWorkingGroups;
        $this->isReceiveNewsletter = $isReceiveNewsletter;
        $this->isRequestNotification = $isRequestNotification;
        $this->gender = $gender;
        $this->files = $files;
        $this->lastNameFurigana = $lastNameFurigana;
        $this->firstNameFurigana = $firstNameFurigana;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->email = $email;
        $this->active = $active;
        $this->organizationId = $organizationId;
        $this->organizationName = $organizationName;
        $this->userType = $userType;
        $this->userId = $userId;
        $this->registerDate = $registerDate;
        $this->loginLastDate = $loginLastDate;
    }
}
