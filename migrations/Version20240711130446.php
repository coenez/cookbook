<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240711130446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C15E237E06 ON category (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6BAF78705E237E06 ON ingredient (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EA750E85E237E06 ON label (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DCBB0C535E237E06 ON unit (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DCBB0C531D775834 ON unit (value)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_64C19C15E237E06 ON category');
        $this->addSql('DROP INDEX UNIQ_6BAF78705E237E06 ON ingredient');
        $this->addSql('DROP INDEX UNIQ_EA750E85E237E06 ON label');
        $this->addSql('DROP INDEX UNIQ_DCBB0C535E237E06 ON unit');
        $this->addSql('DROP INDEX UNIQ_DCBB0C531D775834 ON unit');
    }
}
