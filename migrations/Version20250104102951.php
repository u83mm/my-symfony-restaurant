<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250104102951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE order_backup');
        $this->addSql('ALTER TABLE `order` ADD finished TINYINT(1) DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_backup (id INT AUTO_INCREMENT NOT NULL, table_number SMALLINT NOT NULL, people_qty SMALLINT NOT NULL, aperitifs JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', firsts JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', seconds JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', drinks JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', desserts JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', coffees JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `order` DROP finished');
    }
}
