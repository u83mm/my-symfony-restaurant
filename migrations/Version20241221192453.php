<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241221192453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE orders');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, table_number SMALLINT UNSIGNED NOT NULL, people_qty SMALLINT UNSIGNED NOT NULL, aperitifs LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, aperitifs_qty LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, aperitifs_finished LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'0\' COLLATE `utf8mb4_unicode_ci`, firsts LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, firsts_qty LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, firsts_finished LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'0\' COLLATE `utf8mb4_unicode_ci`, seconds LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, seconds_qty LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, seconds_finished LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'0\' COLLATE `utf8mb4_unicode_ci`, desserts LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, desserts_qty LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, desserts_finished LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'0\' COLLATE `utf8mb4_unicode_ci`, drinks LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, drinks_qty LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, drinks_finished LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'0\' COLLATE `utf8mb4_unicode_ci`, coffees LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, coffees_qty LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, coffees_finished LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'0\' COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
    }
}
