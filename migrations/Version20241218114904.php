<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241218114904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, table_number SMALLINT UNSIGNED NOT NULL, people_qty SMALLINT UNSIGNED NOT NULL, aperitifs LONGTEXT DEFAULT NULL, aperitifs_qty LONGTEXT DEFAULT NULL, aperitifs_finished LONGTEXT DEFAULT \'0\', firsts LONGTEXT DEFAULT NULL, firsts_qty LONGTEXT DEFAULT NULL, firsts_finished LONGTEXT DEFAULT \'0\', seconds LONGTEXT DEFAULT NULL, seconds_qty LONGTEXT DEFAULT NULL, seconds_finished LONGTEXT DEFAULT \'0\', desserts LONGTEXT DEFAULT NULL, desserts_qty LONGTEXT DEFAULT NULL, desserts_finished LONGTEXT DEFAULT \'0\', drinks LONGTEXT DEFAULT NULL, drinks_qty LONGTEXT DEFAULT NULL, drinks_finished LONGTEXT DEFAULT \'0\', coffees LONGTEXT DEFAULT NULL, coffees_qty LONGTEXT DEFAULT NULL, coffees_finished LONGTEXT DEFAULT \'0\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE orders');
    }
}
