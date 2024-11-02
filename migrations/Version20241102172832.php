<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241102172832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tb_user DROP CONSTRAINT fk_d6e3d458296cd8ae');
        $this->addSql('DROP SEQUENCE currency_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE payment_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tb_customer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tb_invoice_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tb_invoice_payment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tb_order_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tb_order_history_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tb_order_package_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tb_order_product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tb_permission_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tb_reminder_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tb_team_id_seq CASCADE');
        $this->addSql('ALTER TABLE tb_order_package DROP CONSTRAINT fk_5badb78e8d9f6d38');
        $this->addSql('ALTER TABLE tb_invoice DROP CONSTRAINT fk_efb2cde68d9f6d38');
        $this->addSql('ALTER TABLE tb_order_product DROP CONSTRAINT fk_568fd4b68d9f6d38');
        $this->addSql('ALTER TABLE tb_order_product DROP CONSTRAINT fk_568fd4b638248176');
        $this->addSql('ALTER TABLE tb_role_permission DROP CONSTRAINT fk_fc1f1ff5d60322ac');
        $this->addSql('ALTER TABLE tb_role_permission DROP CONSTRAINT fk_fc1f1ff5fed90cca');
        $this->addSql('ALTER TABLE tb_reminder DROP CONSTRAINT fk_78905a5ea76ed395');
        $this->addSql('ALTER TABLE tb_invoice_payment DROP CONSTRAINT fk_c9355ad2989f1fd');
        $this->addSql('ALTER TABLE tb_invoice_payment DROP CONSTRAINT fk_c9355ad38248176');
        $this->addSql('ALTER TABLE tb_order DROP CONSTRAINT fk_9fc2c368296cd8ae');
        $this->addSql('ALTER TABLE tb_order DROP CONSTRAINT fk_9fc2c3689395c3f3');
        $this->addSql('ALTER TABLE tb_order DROP CONSTRAINT fk_9fc2c368dc058279');
        $this->addSql('ALTER TABLE tb_order_history DROP CONSTRAINT fk_a27fa0508d9f6d38');
        $this->addSql('DROP TABLE tb_order_package');
        $this->addSql('DROP TABLE tb_team');
        $this->addSql('DROP TABLE tb_invoice');
        $this->addSql('DROP TABLE tb_order_product');
        $this->addSql('DROP TABLE tb_permission');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE tb_role_permission');
        $this->addSql('DROP TABLE tb_reminder');
        $this->addSql('DROP TABLE tb_invoice_payment');
        $this->addSql('DROP TABLE tb_customer');
        $this->addSql('DROP TABLE payment_type');
        $this->addSql('DROP TABLE tb_order');
        $this->addSql('DROP TABLE tb_order_history');
        $this->addSql('DROP INDEX idx_d6e3d458296cd8ae');
        $this->addSql('ALTER TABLE tb_user DROP team_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE currency_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE payment_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tb_customer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tb_invoice_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tb_invoice_payment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tb_order_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tb_order_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tb_order_package_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tb_order_product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tb_permission_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tb_reminder_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tb_team_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE tb_order_package (id BIGINT NOT NULL, order_id BIGINT NOT NULL, lb VARCHAR(10) DEFAULT NULL, height VARCHAR(10) DEFAULT NULL, width VARCHAR(10) DEFAULT NULL, depth VARCHAR(10) DEFAULT NULL, courier VARCHAR(10) DEFAULT NULL, courier_name VARCHAR(100) DEFAULT NULL, service_id VARCHAR(10) DEFAULT NULL, service_name VARCHAR(100) DEFAULT NULL, guide_number VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_5badb78e8d9f6d38 ON tb_order_package (order_id)');
        $this->addSql('CREATE TABLE tb_team (id BIGINT NOT NULL, name VARCHAR(100) NOT NULL, date_created TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, date_updated TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_9f90a40e5e237e06 ON tb_team (name)');
        $this->addSql('CREATE TABLE tb_invoice (id BIGINT NOT NULL, order_id BIGINT NOT NULL, date_created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, employee_name VARCHAR(100) NOT NULL, status_invoice VARCHAR(100) NOT NULL, payment_deadline_invoice VARCHAR(100) NOT NULL, total_rd NUMERIC(10, 2) NOT NULL, deuda_rd NUMERIC(10, 2) NOT NULL, partial_rd NUMERIC(10, 2) NOT NULL, total_usd NUMERIC(10, 2) NOT NULL, deuda_usd NUMERIC(10, 2) NOT NULL, partial_usd NUMERIC(10, 2) NOT NULL, flete NUMERIC(10, 2) NOT NULL, fuel NUMERIC(10, 2) NOT NULL, sure NUMERIC(10, 2) NOT NULL, other_service NUMERIC(10, 2) NOT NULL, fiscal_invoice_number VARCHAR(255) DEFAULT NULL, invoice_file VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_efb2cde68d9f6d38 ON tb_invoice (order_id)');
        $this->addSql('CREATE TABLE tb_order_product (id BIGINT NOT NULL, order_id BIGINT NOT NULL, currency_id INT NOT NULL, product_id VARCHAR(100) DEFAULT NULL, product_id_3pl VARCHAR(100) DEFAULT NULL, warehouse_id VARCHAR(100) DEFAULT NULL, warehouse VARCHAR(100) DEFAULT NULL, category_id VARCHAR(100) DEFAULT NULL, category VARCHAR(100) DEFAULT NULL, sub_category_id VARCHAR(100) DEFAULT NULL, sub_category VARCHAR(100) DEFAULT NULL, brand_id VARCHAR(100) DEFAULT NULL, brand VARCHAR(100) DEFAULT NULL, sku VARCHAR(100) DEFAULT NULL, code VARCHAR(100) DEFAULT NULL, part_number VARCHAR(100) DEFAULT NULL, name VARCHAR(100) DEFAULT NULL, description VARCHAR(100) DEFAULT NULL, weight VARCHAR(100) DEFAULT NULL, condition_id VARCHAR(100) DEFAULT NULL, in_condition VARCHAR(100) DEFAULT NULL, cost NUMERIC(10, 2) DEFAULT NULL, discount NUMERIC(10, 2) DEFAULT NULL, quantity INT DEFAULT NULL, is_onhand VARCHAR(20) DEFAULT NULL, is_commited VARCHAR(20) DEFAULT NULL, is_incomming VARCHAR(20) DEFAULT NULL, is_available VARCHAR(20) DEFAULT NULL, product_dc VARCHAR(100) DEFAULT NULL, product_du VARCHAR(100) DEFAULT NULL, date_created TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, date_updated TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, data_json JSON DEFAULT NULL, data_update_json JSON DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_568fd4b638248176 ON tb_order_product (currency_id)');
        $this->addSql('CREATE INDEX idx_568fd4b68d9f6d38 ON tb_order_product (order_id)');
        $this->addSql('CREATE TABLE tb_permission (id INT NOT NULL, permission_key VARCHAR(100) NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_59d571395e237e06 ON tb_permission (name)');
        $this->addSql('CREATE UNIQUE INDEX uniq_59d571399a0b3198 ON tb_permission (permission_key)');
        $this->addSql('CREATE TABLE currency (id INT NOT NULL, name VARCHAR(25) NOT NULL, sign VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tb_role_permission (role_id INT NOT NULL, permission_id INT NOT NULL, PRIMARY KEY(role_id, permission_id))');
        $this->addSql('CREATE INDEX idx_fc1f1ff5fed90cca ON tb_role_permission (permission_id)');
        $this->addSql('CREATE INDEX idx_fc1f1ff5d60322ac ON tb_role_permission (role_id)');
        $this->addSql('CREATE TABLE tb_reminder (id BIGINT NOT NULL, user_id BIGINT DEFAULT NULL, type_reminder VARCHAR(100) DEFAULT NULL, date_start TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, date_end TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, date_created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_updated TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, hours_worked INT DEFAULT NULL, tags VARCHAR(255) DEFAULT NULL, title VARCHAR(100) NOT NULL, location VARCHAR(100) DEFAULT NULL, description TEXT DEFAULT NULL, url TEXT DEFAULT NULL, notification BOOLEAN DEFAULT NULL, all_day BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_78905a5ea76ed395 ON tb_reminder (user_id)');
        $this->addSql('CREATE TABLE tb_invoice_payment (id BIGINT NOT NULL, invoice_id BIGINT NOT NULL, currency_id INT DEFAULT NULL, amount NUMERIC(10, 2) NOT NULL, payment_type VARCHAR(50) NOT NULL, voucher VARCHAR(100) NOT NULL, voucher_file VARCHAR(255) DEFAULT NULL, voucher_url_file TEXT DEFAULT NULL, date_created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_updated TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, note TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_c9355ad38248176 ON tb_invoice_payment (currency_id)');
        $this->addSql('CREATE INDEX idx_c9355ad2989f1fd ON tb_invoice_payment (invoice_id)');
        $this->addSql('CREATE TABLE tb_customer (id BIGINT NOT NULL, api_id VARCHAR(255) NOT NULL, email VARCHAR(100) DEFAULT NULL, name VARCHAR(100) DEFAULT NULL, last_name VARCHAR(100) DEFAULT NULL, phone_code VARCHAR(100) DEFAULT NULL, phone VARCHAR(100) DEFAULT NULL, cell_phone VARCHAR(100) DEFAULT NULL, customer_type VARCHAR(50) DEFAULT NULL, customer_type_role VARCHAR(100) DEFAULT NULL, identity_type VARCHAR(100) DEFAULT NULL, identity_number VARCHAR(100) DEFAULT NULL, status VARCHAR(50) DEFAULT NULL, gender VARCHAR(50) DEFAULT NULL, birthday DATE DEFAULT NULL, home_address_id VARCHAR(255) DEFAULT NULL, home_country VARCHAR(100) DEFAULT NULL, home_state VARCHAR(100) DEFAULT NULL, home_city VARCHAR(100) DEFAULT NULL, home_address TEXT DEFAULT NULL, home_postal_code VARCHAR(50) DEFAULT NULL, home_add_info TEXT DEFAULT NULL, bill_address_id VARCHAR(255) DEFAULT NULL, bill_name VARCHAR(255) DEFAULT NULL, bill_country VARCHAR(100) DEFAULT NULL, bill_state VARCHAR(100) DEFAULT NULL, bill_city VARCHAR(100) DEFAULT NULL, bill_address TEXT DEFAULT NULL, bill_postal_code VARCHAR(50) DEFAULT NULL, bill_add_info TEXT DEFAULT NULL, date_created TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, date_updated TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, data_json JSON DEFAULT NULL, data_update_json JSON DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_b99e9b17e7927c74 ON tb_customer (email)');
        $this->addSql('CREATE UNIQUE INDEX uniq_b99e9b1754963938 ON tb_customer (api_id)');
        $this->addSql('CREATE TABLE payment_type (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tb_order (id BIGINT NOT NULL, team_id BIGINT DEFAULT NULL, customer_id BIGINT NOT NULL, payment_type_id INT DEFAULT NULL, order_id VARCHAR(100) NOT NULL, status_order VARCHAR(100) DEFAULT NULL, ware_house_id VARCHAR(100) DEFAULT NULL, inventory_id VARCHAR(100) DEFAULT NULL, shipping_international VARCHAR(100) DEFAULT NULL, shipping VARCHAR(100) DEFAULT NULL, bill_file TEXT DEFAULT NULL, payments_files JSON DEFAULT NULL, payments_received_file JSON DEFAULT NULL, debit_credit_notes_files JSON DEFAULT NULL, payments_transaction_codes JSON DEFAULT NULL, shipping_name VARCHAR(100) DEFAULT NULL, shipping_document_type VARCHAR(100) DEFAULT NULL, shipping_document VARCHAR(100) DEFAULT NULL, shipping_phone_cell VARCHAR(100) DEFAULT NULL, shipping_phone_home VARCHAR(100) DEFAULT NULL, shipping_email VARCHAR(100) DEFAULT NULL, shipping_country VARCHAR(100) DEFAULT NULL, shipping_country_name VARCHAR(255) DEFAULT NULL, shipping_state VARCHAR(100) DEFAULT NULL, shipping_state_name VARCHAR(255) DEFAULT NULL, shipping_city VARCHAR(100) DEFAULT NULL, shipping_city_name VARCHAR(255) DEFAULT NULL, shipping_address VARCHAR(100) DEFAULT NULL, shipping_postal_code VARCHAR(50) DEFAULT NULL, shipping_add_info TEXT DEFAULT NULL, bill_address_id VARCHAR(255) DEFAULT NULL, bill_name VARCHAR(255) DEFAULT NULL, bill_identity_type VARCHAR(255) DEFAULT NULL, bill_identity_number VARCHAR(255) DEFAULT NULL, bill_country VARCHAR(100) DEFAULT NULL, bill_country_name VARCHAR(255) DEFAULT NULL, bill_state VARCHAR(100) DEFAULT NULL, bill_state_name VARCHAR(255) DEFAULT NULL, bill_city VARCHAR(100) DEFAULT NULL, bill_city_name VARCHAR(255) DEFAULT NULL, bill_address TEXT DEFAULT NULL, bill_postal_code VARCHAR(50) DEFAULT NULL, bill_add_info TEXT DEFAULT NULL, sub_total_rd NUMERIC(10, 2) DEFAULT NULL, sub_total_usd NUMERIC(10, 2) DEFAULT NULL, product_discount_rd NUMERIC(10, 2) DEFAULT NULL, product_discount_usd NUMERIC(10, 2) DEFAULT NULL, code_promo_discount NUMERIC(10, 2) DEFAULT NULL, tax_rd NUMERIC(10, 2) DEFAULT NULL, tax_usd NUMERIC(10, 2) DEFAULT NULL, shipping_cost NUMERIC(10, 2) DEFAULT NULL, shippingdiscount NUMERIC(10, 2) DEFAULT NULL, order_dc VARCHAR(100) DEFAULT NULL, order_du VARCHAR(100) DEFAULT NULL, total_order_rd NUMERIC(10, 2) DEFAULT NULL, total_order_usd NUMERIC(10, 2) DEFAULT NULL, date_created TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, date_updated TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, data_json JSON DEFAULT NULL, data_update_json JSON DEFAULT NULL, cardnet_session VARCHAR(255) DEFAULT NULL, cardnet_session_key VARCHAR(255) DEFAULT NULL, cardnet_authorization_code VARCHAR(255) DEFAULT NULL, cardnet_tx_token VARCHAR(255) DEFAULT NULL, cardnet_response_code VARCHAR(2) DEFAULT NULL, cardnet_creditcard_number VARCHAR(30) DEFAULT NULL, cardnet_retrival_reference_number VARCHAR(10) DEFAULT NULL, cardnet_remote_response_code VARCHAR(10) DEFAULT NULL, fiscal_invoice_required BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_9fc2c368dc058279 ON tb_order (payment_type_id)');
        $this->addSql('CREATE INDEX idx_9fc2c3689395c3f3 ON tb_order (customer_id)');
        $this->addSql('CREATE INDEX idx_9fc2c368296cd8ae ON tb_order (team_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_9fc2c3688d9f6d38 ON tb_order (order_id)');
        $this->addSql('CREATE TABLE tb_order_history (id BIGINT NOT NULL, order_id BIGINT DEFAULT NULL, data_json JSON NOT NULL, action_name VARCHAR(50) NOT NULL, date_created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_a27fa0508d9f6d38 ON tb_order_history (order_id)');
        $this->addSql('ALTER TABLE tb_order_package ADD CONSTRAINT fk_5badb78e8d9f6d38 FOREIGN KEY (order_id) REFERENCES tb_order (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tb_invoice ADD CONSTRAINT fk_efb2cde68d9f6d38 FOREIGN KEY (order_id) REFERENCES tb_order (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tb_order_product ADD CONSTRAINT fk_568fd4b68d9f6d38 FOREIGN KEY (order_id) REFERENCES tb_order (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tb_order_product ADD CONSTRAINT fk_568fd4b638248176 FOREIGN KEY (currency_id) REFERENCES currency (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tb_role_permission ADD CONSTRAINT fk_fc1f1ff5d60322ac FOREIGN KEY (role_id) REFERENCES tb_role (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tb_role_permission ADD CONSTRAINT fk_fc1f1ff5fed90cca FOREIGN KEY (permission_id) REFERENCES tb_permission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tb_reminder ADD CONSTRAINT fk_78905a5ea76ed395 FOREIGN KEY (user_id) REFERENCES tb_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tb_invoice_payment ADD CONSTRAINT fk_c9355ad2989f1fd FOREIGN KEY (invoice_id) REFERENCES tb_invoice (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tb_invoice_payment ADD CONSTRAINT fk_c9355ad38248176 FOREIGN KEY (currency_id) REFERENCES currency (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tb_order ADD CONSTRAINT fk_9fc2c368296cd8ae FOREIGN KEY (team_id) REFERENCES tb_team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tb_order ADD CONSTRAINT fk_9fc2c3689395c3f3 FOREIGN KEY (customer_id) REFERENCES tb_customer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tb_order ADD CONSTRAINT fk_9fc2c368dc058279 FOREIGN KEY (payment_type_id) REFERENCES payment_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tb_order_history ADD CONSTRAINT fk_a27fa0508d9f6d38 FOREIGN KEY (order_id) REFERENCES tb_order (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "tb_user" ADD team_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE "tb_user" ADD CONSTRAINT fk_d6e3d458296cd8ae FOREIGN KEY (team_id) REFERENCES tb_team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_d6e3d458296cd8ae ON "tb_user" (team_id)');
    }
}
