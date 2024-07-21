<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240721080504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF7870F8BD700D');
        $this->addSql('DROP INDEX IDX_6BAF7870F8BD700D ON ingredient');
        $this->addSql('ALTER TABLE ingredient DROP unit_id');
        $this->addSql('ALTER TABLE recipe_ingredient ADD unit_id INT NOT NULL');
        $this->addSql('ALTER TABLE recipe_ingredient ADD CONSTRAINT FK_22D1FE13F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('CREATE INDEX IDX_22D1FE13F8BD700D ON recipe_ingredient (unit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe_ingredient DROP FOREIGN KEY FK_22D1FE13F8BD700D');
        $this->addSql('DROP INDEX IDX_22D1FE13F8BD700D ON recipe_ingredient');
        $this->addSql('ALTER TABLE recipe_ingredient DROP unit_id');
        $this->addSql('ALTER TABLE ingredient ADD unit_id INT NOT NULL');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6BAF7870F8BD700D ON ingredient (unit_id)');
    }
}
