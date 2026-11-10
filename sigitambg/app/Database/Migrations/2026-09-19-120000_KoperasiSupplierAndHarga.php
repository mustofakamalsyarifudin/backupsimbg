<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KoperasiSupplierAndHarga extends Migration
{
    public function up()
    {
        // supplier_koperasi sudah ada pada database SIGITA lama, tetapi strukturnya
        // masih per-SPPG. Kita perlu menjadikannya master supplier milik Koperasi.
        if ($this->db->tableExists('supplier_koperasi')) {
            $fields = $this->db->getFieldNames('supplier_koperasi');
            $add = [];
            if (!in_array('koperasi_id', $fields, true)) {
                $add['koperasi_id'] = ['type' => 'INT', 'constraint' => 11, 'null' => true, 'after' => 'id'];
            }
            if (!in_array('kode_supplier', $fields, true)) {
                $add['kode_supplier'] = ['type' => 'VARCHAR', 'constraint' => 40, 'null' => true, 'after' => 'koperasi_id'];
            }
            if (!in_array('nama_pic', $fields, true)) {
                $add['nama_pic'] = ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true, 'after' => 'nama_supplier'];
            }
            if (!in_array('no_hp', $fields, true)) {
                $add['no_hp'] = ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true, 'after' => 'nama_pic'];
            }
            if (!in_array('kabupaten_kota', $fields, true)) {
                $add['kabupaten_kota'] = ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'after' => 'alamat'];
            }
            if (!in_array('provinsi', $fields, true)) {
                $add['provinsi'] = ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'after' => 'kabupaten_kota'];
            }
            if (!in_array('npwp_nik', $fields, true)) {
                $add['npwp_nik'] = ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true, 'after' => 'provinsi'];
            }
            if (!in_array('email', $fields, true)) {
                $add['email'] = ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true, 'after' => 'npwp_nik'];
            }
            if (!in_array('tanggal_mou_mulai', $fields, true)) {
                $add['tanggal_mou_mulai'] = ['type' => 'DATE', 'null' => true, 'after' => 'email'];
            }
            if (!in_array('tanggal_mou_akhir', $fields, true)) {
                $add['tanggal_mou_akhir'] = ['type' => 'DATE', 'null' => true, 'after' => 'tanggal_mou_mulai'];
            }
            if (!in_array('status', $fields, true)) {
                $add['status'] = ['type' => 'ENUM', 'constraint' => ['aktif', 'nonaktif'], 'default' => 'aktif', 'after' => 'tanggal_mou_akhir'];
            }
            if (!in_array('catatan', $fields, true)) {
                $add['catatan'] = ['type' => 'TEXT', 'null' => true, 'after' => 'status'];
            }
            if ($add) $this->forge->addColumn('supplier_koperasi', $add);

            // Supplier sekarang dimiliki Koperasi, bukan SPPG tertentu.
            $this->forge->modifyColumn('supplier_koperasi', [
                'id_sppg' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
                'tanggal' => ['type' => 'DATE', 'null' => true],
            ]);
        } else {
            $this->forge->addField([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'koperasi_id' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
                'kode_supplier' => ['type' => 'VARCHAR', 'constraint' => 40],
                'nama_supplier' => ['type' => 'VARCHAR', 'constraint' => 200],
                'nama_pic' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
                'no_hp' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
                'alamat' => ['type' => 'TEXT', 'null' => true],
                'kabupaten_kota' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
                'provinsi' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
                'npwp_nik' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
                'email' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
                'tanggal_mou_mulai' => ['type' => 'DATE', 'null' => true],
                'tanggal_mou_akhir' => ['type' => 'DATE', 'null' => true],
                'status' => ['type' => 'ENUM', 'constraint' => ['aktif', 'nonaktif'], 'default' => 'aktif'],
                'catatan' => ['type' => 'TEXT', 'null' => true],
                'created_by' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('supplier_koperasi');
        }

        if ($this->db->tableExists('supplier_koperasi')) {
            try { $this->forge->addKey(['koperasi_id', 'kode_supplier'], false, true, 'uq_supplier_koperasi_kode'); } catch (\Throwable $e) { log_message('debug', $e->getMessage()); }
            try { $this->forge->addKey(['koperasi_id', 'status'], false, false, 'idx_supplier_koperasi_status'); } catch (\Throwable $e) { log_message('debug', $e->getMessage()); }
        }

        $this->createJenisDokumen();
        foreach (['NIB','NPWP','KTP PIC','Akta/Legalitas','Surat Kerja Sama / MOU','Sertifikat','Dokumen Rekening','Dokumen Lainnya'] as $name) {
            $exists = $this->db->table('master_jenis_dokumen_supplier')->where('nama_jenis', $name)->get()->getRowArray();
            if (!$exists) {
                $this->db->table('master_jenis_dokumen_supplier')->insert(['nama_jenis'=>$name,'status'=>'aktif','keterangan'=>null,'created_by'=>null,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
            }
        }
        $this->createSupplierBerkas();
        $this->createSupplierBahan();
        $this->createSupplierBahanHarga();
        $this->extendPembelian();
        $this->extendPembelianDetail();
    }

    private function createJenisDokumen(): void
    {
        if ($this->db->tableExists('master_jenis_dokumen_supplier')) return;
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_jenis' => ['type' => 'VARCHAR', 'constraint' => 100],
            'status' => ['type' => 'ENUM', 'constraint' => ['aktif', 'nonaktif'], 'default' => 'aktif'],
            'keterangan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('nama_jenis', false, true, 'uq_jenis_dokumen_supplier');
        $this->forge->createTable('master_jenis_dokumen_supplier');
    }

    private function createSupplierBerkas(): void
    {
        if ($this->db->tableExists('supplier_koperasi_berkas')) return;
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'supplier_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jenis_dokumen_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_berkas' => ['type' => 'VARCHAR', 'constraint' => 200],
            'file_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'file_path' => ['type' => 'VARCHAR', 'constraint' => 500],
            'file_type' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'file_size' => ['type' => 'BIGINT', 'null' => true],
            'keterangan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['supplier_id', 'jenis_dokumen_id']);
        $this->forge->createTable('supplier_koperasi_berkas');
    }

    private function createSupplierBahan(): void
    {
        if ($this->db->tableExists('supplier_bahan')) return;
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'supplier_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'bahan_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'harga_beli' => ['type' => 'DECIMAL', 'constraint' => '18,2', 'default' => 0],
            'minimum_order' => ['type' => 'DECIMAL', 'constraint' => '18,2', 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['aktif', 'nonaktif'], 'default' => 'aktif'],
            'keterangan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'updated_by' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['supplier_id', 'bahan_id'], false, true, 'uq_supplier_bahan');
        $this->forge->addKey(['bahan_id', 'status'], false, false, 'idx_supplier_bahan_bahan');
        $this->forge->createTable('supplier_bahan');
    }

    private function createSupplierBahanHarga(): void
    {
        if ($this->db->tableExists('supplier_bahan_harga')) return;
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'supplier_bahan_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'harga_lama' => ['type' => 'DECIMAL', 'constraint' => '18,2', 'default' => 0],
            'harga_baru' => ['type' => 'DECIMAL', 'constraint' => '18,2', 'default' => 0],
            'berlaku_mulai' => ['type' => 'DATE', 'null' => true],
            'diubah_oleh' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'keterangan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['supplier_bahan_id', 'created_at']);
        $this->forge->createTable('supplier_bahan_harga');
    }

    private function extendPembelian(): void
    {
        if (!$this->db->tableExists('koperasi_pembelian')) return;
        $fields = $this->db->getFieldNames('koperasi_pembelian');
        $add = [];
        if (!in_array('supplier_id', $fields, true)) $add['supplier_id'] = ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'after' => 'supplier'];
        if (!in_array('total_harga_beli', $fields, true)) $add['total_harga_beli'] = ['type' => 'DECIMAL', 'constraint' => '18,2', 'default' => 0, 'after' => 'total'];
        if (!in_array('total_margin', $fields, true)) $add['total_margin'] = ['type' => 'DECIMAL', 'constraint' => '18,2', 'default' => 0, 'after' => 'total_harga_beli'];
        if (!in_array('margin_persen', $fields, true)) $add['margin_persen'] = ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0, 'after' => 'total_margin'];
        if ($add) $this->forge->addColumn('koperasi_pembelian', $add);
    }

    private function extendPembelianDetail(): void
    {
        if (!$this->db->tableExists('koperasi_pembelian_detail')) return;
        $fields = $this->db->getFieldNames('koperasi_pembelian_detail');
        $add = [];
        if (!in_array('supplier_bahan_id', $fields, true)) $add['supplier_bahan_id'] = ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'after' => 'bahan_id'];
        if (!in_array('harga_beli_snapshot', $fields, true)) $add['harga_beli_snapshot'] = ['type' => 'DECIMAL', 'constraint' => '18,2', 'default' => 0, 'after' => 'harga_satuan'];
        if (!in_array('harga_jual_snapshot', $fields, true)) $add['harga_jual_snapshot'] = ['type' => 'DECIMAL', 'constraint' => '18,2', 'default' => 0, 'after' => 'harga_beli_snapshot'];
        if (!in_array('margin_snapshot', $fields, true)) $add['margin_snapshot'] = ['type' => 'DECIMAL', 'constraint' => '18,2', 'default' => 0, 'after' => 'harga_jual_snapshot'];
        if (!in_array('margin_persen_snapshot', $fields, true)) $add['margin_persen_snapshot'] = ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0, 'after' => 'margin_snapshot'];
        if ($add) $this->forge->addColumn('koperasi_pembelian_detail', $add);
    }

    public function down()
    {
        // Intentionally conservative: this migration is additive in production.
        // Do not drop existing transaction data during rollback.
    }
}
