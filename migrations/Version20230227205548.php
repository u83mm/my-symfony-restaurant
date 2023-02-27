<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227205548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dish DROP FOREIGN KEY FK_957D8CB8F25EA516');
        $this->addSql('DROP INDEX IDX_957D8CB8F25EA516 ON dish');
        $this->addSql('ALTER TABLE dish CHANGE dish_menu_id_id dish_menu_id INT NOT NULL');
        $this->addSql('ALTER TABLE dish ADD CONSTRAINT FK_957D8CB85C60F384 FOREIGN KEY (dish_menu_id) REFERENCES dish_menu (id)');
        $this->addSql('CREATE INDEX IDX_957D8CB85C60F384 ON dish (dish_menu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dish DROP FOREIGN KEY FK_957D8CB85C60F384');
        $this->addSql('DROP INDEX IDX_957D8CB85C60F384 ON dish');
        $this->addSql('ALTER TABLE dish CHANGE dish_menu_id dish_menu_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE dish ADD CONSTRAINT FK_957D8CB8F25EA516 FOREIGN KEY (dish_menu_id_id) REFERENCES dish_menu (id)');
        $this->addSql('CREATE INDEX IDX_957D8CB8F25EA516 ON dish (dish_menu_id_id)');
    }
}
