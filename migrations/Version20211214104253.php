<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211214104253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adress (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, adress LONGTEXT NOT NULL, cp INT NOT NULL, city VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, INDEX IDX_5CECC7BEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, order_id_id INT NOT NULL, user_id INT NOT NULL, orderdetail_id_id INT NOT NULL, UNIQUE INDEX UNIQ_90651744FCDAEAAA (order_id_id), INDEX IDX_90651744A76ED395 (user_id), INDEX IDX_9065174447BB9876 (orderdetail_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opinions (id INT AUTO_INCREMENT NOT NULL, stars INT NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orderbuy (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, adress_id_id INT NOT NULL, total INT NOT NULL, total_ttc INT NOT NULL, status VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_245D2A7FA76ED395 (user_id), INDEX IDX_245D2A7F77861D51 (adress_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orderdetails (id INT AUTO_INCREMENT NOT NULL, orderbuy_id_id INT NOT NULL, quantity INT NOT NULL, price_total INT NOT NULL, INDEX IDX_489AFCDC825AC339 (orderbuy_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE polluting (id INT AUTO_INCREMENT NOT NULL, subst VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE polluting_product (polluting_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_251118C627A09CC1 (polluting_id), INDEX IDX_251118C64584665A (product_id), PRIMARY KEY(polluting_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, greatness INT NOT NULL, pot INT NOT NULL, toxicity VARCHAR(255) NOT NULL, familly VARCHAR(255) NOT NULL, price INT NOT NULL, water INT NOT NULL, entretient INT NOT NULL, path_image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rooms (id INT AUTO_INCREMENT NOT NULL, room VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rooms_product (rooms_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_632154A38E2368AB (rooms_id), INDEX IDX_632154A34584665A (product_id), PRIMARY KEY(rooms_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, familly_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adress ADD CONSTRAINT FK_5CECC7BEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES orderbuy (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_9065174447BB9876 FOREIGN KEY (orderdetail_id_id) REFERENCES orderdetails (id)');
        $this->addSql('ALTER TABLE orderbuy ADD CONSTRAINT FK_245D2A7FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE orderbuy ADD CONSTRAINT FK_245D2A7F77861D51 FOREIGN KEY (adress_id_id) REFERENCES adress (id)');
        $this->addSql('ALTER TABLE orderdetails ADD CONSTRAINT FK_489AFCDC825AC339 FOREIGN KEY (orderbuy_id_id) REFERENCES orderbuy (id)');
        $this->addSql('ALTER TABLE polluting_product ADD CONSTRAINT FK_251118C627A09CC1 FOREIGN KEY (polluting_id) REFERENCES polluting (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE polluting_product ADD CONSTRAINT FK_251118C64584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rooms_product ADD CONSTRAINT FK_632154A38E2368AB FOREIGN KEY (rooms_id) REFERENCES rooms (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rooms_product ADD CONSTRAINT FK_632154A34584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orderbuy DROP FOREIGN KEY FK_245D2A7F77861D51');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744FCDAEAAA');
        $this->addSql('ALTER TABLE orderdetails DROP FOREIGN KEY FK_489AFCDC825AC339');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_9065174447BB9876');
        $this->addSql('ALTER TABLE polluting_product DROP FOREIGN KEY FK_251118C627A09CC1');
        $this->addSql('ALTER TABLE polluting_product DROP FOREIGN KEY FK_251118C64584665A');
        $this->addSql('ALTER TABLE rooms_product DROP FOREIGN KEY FK_632154A34584665A');
        $this->addSql('ALTER TABLE rooms_product DROP FOREIGN KEY FK_632154A38E2368AB');
        $this->addSql('ALTER TABLE adress DROP FOREIGN KEY FK_5CECC7BEA76ED395');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744A76ED395');
        $this->addSql('ALTER TABLE orderbuy DROP FOREIGN KEY FK_245D2A7FA76ED395');
        $this->addSql('DROP TABLE adress');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE opinions');
        $this->addSql('DROP TABLE orderbuy');
        $this->addSql('DROP TABLE orderdetails');
        $this->addSql('DROP TABLE polluting');
        $this->addSql('DROP TABLE polluting_product');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE rooms');
        $this->addSql('DROP TABLE rooms_product');
        $this->addSql('DROP TABLE user');
    }
}
