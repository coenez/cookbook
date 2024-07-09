<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240709134214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP slug');
        $this->addSql('ALTER TABLE ingredient ADD unit VARCHAR(4) NOT NULL, DROP slug');
        $this->addSql('ALTER TABLE recipe DROP slug');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD slug VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE ingredient ADD slug VARCHAR(100) NOT NULL, DROP unit');
        $this->addSql('ALTER TABLE recipe ADD slug VARCHAR(100) NOT NULL');
    }
}
