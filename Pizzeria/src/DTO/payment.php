<?php

namespace App\DTO;

use App\Entity\Address;

class payment
{
    public Address $address;

    public string $cardNumber;

    public string $expirationMonth;

    public string $expirationYear;

    public string $cvc;

    
}