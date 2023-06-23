<?php

declare(strict_types=1);

namespace Phpolar\Example;

use DateTimeImmutable;
use Phpolar\Model\AbstractModel;
use Phpolar\Model\Column;
use Phpolar\Model\Label;
use Phpolar\Model\Hidden;
use Phpolar\Model\PrimaryKey;
use Phpolar\Validators\Max;
use Phpolar\Validators\MaxLength;
use Phpolar\Validators\Pattern;
use Phpolar\Validators\Required;

class Person extends AbstractModel
{
    #[MaxLength(20)]
    #[PrimaryKey]
    #[Hidden]
    public string $id;

    #[Label("First Name")]
    #[Column("First Name")]
    #[Required]
    #[MaxLength(50)]
    public string $firstName;

    #[Label("Last Name")]
    #[Column("Last Name")]
    #[Required]
    #[MaxLength(50)]
    public string $lastName;

    #[Max(150)]
    #[Column("Age")]
    public int $age;

    #[Pattern("/.+,\s?[A-Z]{2}/s")]
    #[MaxLength(150)]
    public string $birthplace;

    #[MaxLength(150)]
    public string $occupation;

    #[MaxLength(240)]
    public string $notes;

    #[Hidden]
    #[Column("Created On")]
    public DateTimeImmutable $createdOn;

    #[Label("Date of birth")]
    #[Column("Date of birth")]
    public DateTimeImmutable $dateOfBirth;

    public function create(): void
    {
        $this->id = uniqid();
        $this->createdOn = new DateTimeImmutable("now");
    }
}
