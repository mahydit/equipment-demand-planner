<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210814160851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE campervan (id INT AUTO_INCREMENT NOT NULL, at_station_id INT DEFAULT NULL, car_number VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, is_on_the_road TINYINT(1) NOT NULL, INDEX IDX_6891BB7FD22C0C73 (at_station_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portable_eqipment (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, at_station_id INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, is_used TINYINT(1) NOT NULL, INDEX IDX_BF752834C54C8C93 (type_id), INDEX IDX_BF752834D22C0C73 (at_station_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portable_eqipment_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rental_order (id INT AUTO_INCREMENT NOT NULL, start_station_id INT DEFAULT NULL, end_station_id INT DEFAULT NULL, campervan_id INT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, INDEX IDX_6EC21D7753721DCB (start_station_id), INDEX IDX_6EC21D772FF5EABB (end_station_id), INDEX IDX_6EC21D77B9D53E94 (campervan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rental_order_portable_eqipment (rental_order_id INT NOT NULL, portable_eqipment_id INT NOT NULL, INDEX IDX_417596CBDF9740B (rental_order_id), INDEX IDX_417596C3811A3DA (portable_eqipment_id), PRIMARY KEY(rental_order_id, portable_eqipment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE campervan ADD CONSTRAINT FK_6891BB7FD22C0C73 FOREIGN KEY (at_station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE portable_eqipment ADD CONSTRAINT FK_BF752834C54C8C93 FOREIGN KEY (type_id) REFERENCES portable_eqipment_type (id)');
        $this->addSql('ALTER TABLE portable_eqipment ADD CONSTRAINT FK_BF752834D22C0C73 FOREIGN KEY (at_station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE rental_order ADD CONSTRAINT FK_6EC21D7753721DCB FOREIGN KEY (start_station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE rental_order ADD CONSTRAINT FK_6EC21D772FF5EABB FOREIGN KEY (end_station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE rental_order ADD CONSTRAINT FK_6EC21D77B9D53E94 FOREIGN KEY (campervan_id) REFERENCES campervan (id)');
        $this->addSql('ALTER TABLE rental_order_portable_eqipment ADD CONSTRAINT FK_417596CBDF9740B FOREIGN KEY (rental_order_id) REFERENCES rental_order (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rental_order_portable_eqipment ADD CONSTRAINT FK_417596C3811A3DA FOREIGN KEY (portable_eqipment_id) REFERENCES portable_eqipment (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rental_order DROP FOREIGN KEY FK_6EC21D77B9D53E94');
        $this->addSql('ALTER TABLE rental_order_portable_eqipment DROP FOREIGN KEY FK_417596C3811A3DA');
        $this->addSql('ALTER TABLE portable_eqipment DROP FOREIGN KEY FK_BF752834C54C8C93');
        $this->addSql('ALTER TABLE rental_order_portable_eqipment DROP FOREIGN KEY FK_417596CBDF9740B');
        $this->addSql('ALTER TABLE campervan DROP FOREIGN KEY FK_6891BB7FD22C0C73');
        $this->addSql('ALTER TABLE portable_eqipment DROP FOREIGN KEY FK_BF752834D22C0C73');
        $this->addSql('ALTER TABLE rental_order DROP FOREIGN KEY FK_6EC21D7753721DCB');
        $this->addSql('ALTER TABLE rental_order DROP FOREIGN KEY FK_6EC21D772FF5EABB');
        $this->addSql('DROP TABLE campervan');
        $this->addSql('DROP TABLE portable_eqipment');
        $this->addSql('DROP TABLE portable_eqipment_type');
        $this->addSql('DROP TABLE rental_order');
        $this->addSql('DROP TABLE rental_order_portable_eqipment');
        $this->addSql('DROP TABLE station');
    }
}
