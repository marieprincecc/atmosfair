<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211206123452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orderdetails (id INT AUTO_INCREMENT NOT NULL, orderbuy_id_id INT NOT NULL, quantity INT NOT NULL, price_total INT NOT NULL, INDEX IDX_489AFCDC825AC339 (orderbuy_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orderdetails_product (orderdetails_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_8110F0834A01DDC7 (orderdetails_id), INDEX IDX_8110F0834584665A (product_id), PRIMARY KEY(orderdetails_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE polluting (id INT AUTO_INCREMENT NOT NULL, subst VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE polluting_product (polluting_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_251118C627A09CC1 (polluting_id), INDEX IDX_251118C64584665A (product_id), PRIMARY KEY(polluting_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rooms (id INT AUTO_INCREMENT NOT NULL, room VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rooms_product (rooms_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_632154A38E2368AB (rooms_id), INDEX IDX_632154A34584665A (product_id), PRIMARY KEY(rooms_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orderdetails ADD CONSTRAINT FK_489AFCDC825AC339 FOREIGN KEY (orderbuy_id_id) REFERENCES orderbuy (id)');
        $this->addSql('ALTER TABLE orderdetails_product ADD CONSTRAINT FK_8110F0834A01DDC7 FOREIGN KEY (orderdetails_id) REFERENCES orderdetails (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orderdetails_product ADD CONSTRAINT FK_8110F0834584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE polluting_product ADD CONSTRAINT FK_251118C627A09CC1 FOREIGN KEY (polluting_id) REFERENCES polluting (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE polluting_product ADD CONSTRAINT FK_251118C64584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rooms_product ADD CONSTRAINT FK_632154A38E2368AB FOREIGN KEY (rooms_id) REFERENCES rooms (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rooms_product ADD CONSTRAINT FK_632154A34584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orderdetails_product DROP FOREIGN KEY FK_8110F0834A01DDC7');
        $this->addSql('ALTER TABLE polluting_product DROP FOREIGN KEY FK_251118C627A09CC1');
        $this->addSql('ALTER TABLE rooms_product DROP FOREIGN KEY FK_632154A38E2368AB');
        $this->addSql('DROP TABLE orderdetails');
        $this->addSql('DROP TABLE orderdetails_product');
        $this->addSql('DROP TABLE polluting');
        $this->addSql('DROP TABLE polluting_product');
        $this->addSql('DROP TABLE rooms');
        $this->addSql('DROP TABLE rooms_product');
    }
}
