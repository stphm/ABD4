<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230302164606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_ticket ALTER owner_first_name DROP NOT NULL');
        $this->addSql('ALTER TABLE booking_ticket ALTER owner_last_name DROP NOT NULL');
        $this->addSql('ALTER TABLE booking_ticket ALTER owner_age DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE booking_ticket ALTER owner_first_name SET NOT NULL');
        $this->addSql('ALTER TABLE booking_ticket ALTER owner_last_name SET NOT NULL');
        $this->addSql('ALTER TABLE booking_ticket ALTER owner_age SET NOT NULL');
    }
}
