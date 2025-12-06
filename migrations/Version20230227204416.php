<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227204416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dish ADD dish_day_id INT NOT NULL');
        $this->addSql('ALTER TABLE dish ADD CONSTRAINT FK_957D8CB81C54629 FOREIGN KEY (dish_day_id) REFERENCES dish_day (id)');
        $this->addSql('CREATE INDEX IDX_957D8CB81C54629 ON dish (dish_day_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dish DROP FOREIGN KEY FK_957D8CB81C54629');
        $this->addSql('DROP INDEX IDX_957D8CB81C54629 ON dish');
        $this->addSql('ALTER TABLE dish DROP dish_day_id');
    }
}
