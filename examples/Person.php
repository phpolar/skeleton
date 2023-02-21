<?php

declare(strict_types=1);

namespace Phpolar\Example;

use DateTimeImmutable;
use Phpolar\Phpolar\Model\AbstractModel;
use Phpolar\Phpolar\Model\Column;
use Phpolar\Phpolar\Model\Label;
use Phpolar\Phpolar\Validation\Max;
use Phpolar\Phpolar\Validation\MaxLength;
use Phpolar\Phpolar\Validation\Pattern;
use Phpolar\Phpolar\Validation\Required;

class Person extends AbstractModel
{
    #[Label("First Name")]
    #[Column("First Name")]
    #[Required]
    #[MaxLength(50)]
    public string $firstName = "";

    #[Label("Last Name")]
    #[Column("Last Name")]
    #[Required]
    #[MaxLength(50)]
    public string $lastName = "";

    #[Max(150)]
    #[Column("Age")]
    public int $age = 0;

    #[Pattern("/.+,\s*[[:alpha:]]{2}/s")]
    #[MaxLength(150)]
    public string $birthplace = "";

    #[MaxLength(150)]
    public string $occupation = "";

    #[MaxLength(240)]
    public string $notes = "";

    #[Label("Date of birth")]
    public ?DateTimeImmutable $dateOfBirth;
}
