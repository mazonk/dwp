<?php
require_once 'src/model/entity/Address.php';

class CompanyInfo
{
    private int $companyInfoId;
    private string $companyName;
    private string $companyDescription;
    private string $logoUrl;
    private Address $address;

    public function __construct(int $companyInfoId, string $companyName, string $companyDescription, string $logoUrl, Address $address)
    {
        $this->companyInfoId = $companyInfoId;
        $this->companyName = $companyName;
        $this->companyDescription = $companyDescription;
        $this->logoUrl = $logoUrl;
        $this->address = $address;
    }

    public function getCompanyInfoId(): int
    {
        return $this->companyInfoId;
    }

    public function setCompanyInfoId(int $companyInfoId): void
    {
        $this->companyInfoId = $companyInfoId;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): void
    {
        $this->companyName = $companyName;
    }

    public function getCompanyDescription(): string
    {
        return $this->companyDescription;
    }

    public function setCompanyDescription(string $companyDescription): void
    {
        $this->companyDescription = $companyDescription;
    }

    public function getLogoUrl(): string
    {
        return $this->logoUrl;
    }

    public function setLogoUrl(string $logoUrl): void
    {
        $this->logoUrl = $logoUrl;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }
}