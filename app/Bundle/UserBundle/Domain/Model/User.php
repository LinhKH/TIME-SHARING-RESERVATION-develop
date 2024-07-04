<?php
namespace App\Bundle\UserBundle\Domain\Model;

final class User {
    /**
     * @var \App\Bundle\UserBundle\Domain\Model\UserId|null
     */
    private ?UserId $userId;
    /**
     * @var \App\Bundle\UserBundle\Domain\Model\OrganizationId
     */
    private OrganizationId $organizationId;
    /**
     * @var \App\Bundle\UserBundle\Domain\Model\UserType
     */
    private UserType $userType;
    /**
     * @var bool
     */
    private bool $isActive;
    /**
     * @var string
     */
    private string $firstName;
    /**
     * @var string
     */
    private string $lastName;
    /**
     * @var string
     */
    private string $firstNameFurigana;
    /**
     * @var string
     */
    private string $lastNameFurigana;
    /**
     * @var array
     */
    private array $files;
    /**
     * @var \App\Bundle\UserBundle\Domain\Model\GenderType
     */
    private GenderType $genderType;
    /**
     * @var string
     */
    private string $email;
    /**
     * @var bool
     */
    private bool $isRequestNotification;
    /**
     * @var bool
     */
    private bool $isReceiveEmail;
    /**
     * @var \App\Bundle\UserBundle\Domain\Model\UserRole[]
     */
    private array $userRoles;
    /**
     * @var \App\Bundle\UserBundle\Domain\Model\UserWorkingGroup[]
     */
    private array $userWorkingGroups;
    /**
     * @var string|null
     */
    private ?string $password;
    /**
     * @var string|null
     */
    private ?string $registerDate;
    /**
     * @var string|null
     */
    private ?string $loginLastDate;
    private ?string $organizationName;

    /**
     * @param \App\Bundle\UserBundle\Domain\Model\UserId|null $userId userId
     * @param \App\Bundle\UserBundle\Domain\Model\OrganizationId $organizationId organizationId
     * @param \App\Bundle\UserBundle\Domain\Model\UserType $userType userType
     * @param bool $isActive isActive
     * @param string $firstName firstName
     * @param string $lastName lastName
     * @param string $firstNameFurigana firstNameFurigana
     * @param string $lastNameFurigana lastNameFurigana
     * @param array $files files
     * @param \App\Bundle\UserBundle\Domain\Model\GenderType $genderType genderType
     * @param string $email email
     * @param bool $isRequestNotification isRequestNotification
     * @param bool $isReceiveEmail isReceiveEmail
     * @param \App\Bundle\UserBundle\Domain\Model\UserRole[] $userRoles userRoles
     * @param \App\Bundle\UserBundle\Domain\Model\UserWorkingGroup[] $userWorkingGroups userWorkingGroups
     * @param string|null $password password
     * @param string|null $registerDate registerDate
     * @param string|null $loginLastDate loginLastDate
     */
    public function __construct(
        ?UserId $userId,
        OrganizationId $organizationId,
        UserType $userType,
        bool $isActive,
        string $firstName,
        string $lastName,
        string $firstNameFurigana,
        string $lastNameFurigana,
        array $files,
        GenderType $genderType,
        string $email,
        bool $isRequestNotification,
        bool $isReceiveEmail,
        array $userRoles,
        array $userWorkingGroups,
        ?string $password,
        ?string $registerDate,
        ?string $loginLastDate,
        ?string $organizationName
    ) {
        $this->organizationName = $organizationName;
        $this->loginLastDate = $loginLastDate;
        $this->registerDate = $registerDate;
        $this->password = $password;
        $this->userWorkingGroups = $userWorkingGroups;
        $this->userRoles = $userRoles;
        $this->isRequestNotification = $isRequestNotification;
        $this->isReceiveEmail = $isReceiveEmail;
        $this->email = $email;
        $this->genderType = $genderType;
        $this->files = $files;
        $this->lastNameFurigana = $lastNameFurigana;
        $this->firstNameFurigana = $firstNameFurigana;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->isActive = $isActive;
        $this->userType = $userType;
        $this->organizationId = $organizationId;
        $this->userId = $userId;
    }

    /**
     * @return \App\Bundle\UserBundle\Domain\Model\UserId|null
     */
    public function getUserId(): ?UserId
    {
        return $this->userId;
    }

    /**
     * @return \App\Bundle\UserBundle\Domain\Model\OrganizationId
     */
    public function getOrganizationId(): OrganizationId
    {
        return $this->organizationId;
    }

    /**
     * @return bool
     */
    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getFirstNameFurigana(): string
    {
        return $this->firstNameFurigana;
    }

    /**
     * @return string
     */
    public function getLastNameFurigana(): string
    {
        return $this->lastNameFurigana;
    }

     /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @return \App\Bundle\UserBundle\Domain\Model\GenderType
     */
    public function getGenderType(): GenderType
    {
        return $this->genderType;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return bool
     */
    public function getRequestNotification(): bool
    {
        return $this->isRequestNotification;
    }

    /**
     * @return bool
     */
    public function getReceiveEmail(): bool
    {
        return $this->isReceiveEmail;
    }

    /**
     * @return string|null
     */
    public function getRegisterDate()
    {
        return $this->registerDate;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return string|null
     */
    public function getLoginLastDate(): ?string
    {
        return $this->loginLastDate;
    }

    /**
     * @return UserType
     */
    public function getUserType(): UserType
    {
        return $this->userType;
    }

    /**
     * @return UserRole[]
     */
    public function getUserRoles(): array
    {
        return $this->userRoles;
    }

    /**
     * @return UserWorkingGroup[]
     */
    public function getUserWorkingGroups(): array
    {
        return $this->userWorkingGroups;
    }

    /**
     * @return string
     */
    public function getUserRoleWithJson(): string
    {
        $userRoles = [];
        foreach($this->userRoles as $userRole) {
            $userRoles[] = $userRole->getValue();
        }

        return json_encode($userRoles);
    }

    /**
     * @return string
     */
    public function getUserWorkingGroupsWithJson(): string
    {
        $userWorkingGroups = [];
        foreach($this->userWorkingGroups as $userWorkingGroup) {
            $userWorkingGroups[] = $userWorkingGroup->getValue();
        }

        return json_encode($userWorkingGroups);
    }

    /**
     * @return string|null
     */
    public function getOrganizationName(): ?string
    {
        return $this->organizationName;
    }


    /**
     * @return string|null
     */
    public function getFullName(): ?string
    {
        $full_name = null;
        if ($this->getLastName()) {
            $full_name .= $this->getLastName();
        }
        if ($this->getFirstName()) {
            if (!$full_name) {
                $full_name .= ' ';
            }
            $full_name .= $this->getFirstName();
        }
        return $full_name;
    }
}
