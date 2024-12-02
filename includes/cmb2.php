<?php

add_action('cmb2_init', 'pekerjaan_metabox_metabox');
function pekerjaan_metabox_metabox()
{
    $user_id = $_GET['user_id'] ?? '';

    $prefix = '';
    // Buat metabox
    $cmb_group = new_cmb2_box(array(
        'id'            => 'pekerjaan_metabox',
        'title'         => esc_html__('Pekerjaan Details', 'text-domain'),
        'object_types'  => array('draft_kerja'), // Ganti 'post' dengan jenis postingan yang Anda inginkan
    ));

    $cmb_group->add_field(array(
        'name'             => 'Default',
        'id'               => 'job_desk_status',
        'type'             => 'hidden',
        'default'          => 'aktif',
    ));

    // Field Pilihan Pelanggan
    $cmb_group->add_field(array(
        'name'             => 'Pilih Konsumen',
        'id'               => $prefix . 'customer_select',
        'type'             => 'select',
        'options_cb'       => 'get_customer_posts',
        'default'          => $user_id
    ));

    $cmb_group->add_field(array(
        'name'             => 'Tanggal Order',
        'id'               => $prefix . 'tanggal_order',
        'type'             => 'text',
        'attributes' => array(
            'autocomplete' => 'off',
            'type' => 'date'
        ),
    ));

    // $cmb_group->add_field(array(
    //     'name'             => 'Layanan',
    //     'id'               => $prefix . 'layanan',
    //     'type'             => 'text',
    // ));

    $cmb_group->add_field(array(
        'name'             => 'Biaya Notaris',
        'id'               => $prefix . 'biaya_transaksi',
        'type'             => 'text',
        'attributes' => array('class' => 'format-rupiah form-control'),
    ));

    $cmb_group->add_field(array(
        'name'    => 'Jenis Pembayaran',
        'id'      => 'jenis_pembayaran',
        'type'    => 'radio_inline',
        'options' => array(
            'tunai' => __('Tunai', 'cmb2'),
            'transfer'   => __('Transfer', 'cmb2'),
        ),
        'default' => 'standard',
    ));

    $cmb_group->add_field(array(
        'name'             => 'Dibayar',
        'id'               => $prefix . 'dibayar',
        'type'             => 'text',
    ));


    $cmb_group->add_field(array(
        'name' => 'Sertipikat Asli',
        'desc' => 'konsumen menyertakan sertipikat asli.',
        'id'   => 'sertipikat_asli',
        'type' => 'checkbox',
    ));
    $cmb_group->add_field(array(
        'name' => 'PBB',
        'desc' => 'konsumen menyertakan PBB.',
        'id'   => 'pbb',
        'type' => 'checkbox',
    ));
    $cmb_group->add_field(array(
        'name' => 'KTP',
        'desc' => 'konsumen menyertakan KTP.',
        'id'   => 'ktp',
        'type' => 'checkbox',
    ));
    $cmb_group->add_field(array(
        'name' => 'KK',
        'desc' => 'konsumen menyertakan KK.',
        'id'   => 'kk',
        'type' => 'checkbox',
    ));

    $cmb_group->add_field(array(
        'name' => 'Lain - lain',
        // 'desc' => 'field description (optional)',
        'default' => '',
        'id' => 'lain_lain',
        'type' => 'textarea_small'
    ));

    // $cmb_group->add_field(array(
    //     'name' => esc_html__('Status', 'text-domain'),
    //     'id'   => 'status_post',
    //     'type' => 'select',
    //     'column' => true,
    //     'options' => array(
    //         'aktif' => 'Aktif',
    //         'archive' => 'Archive',
    //     ),
    // ));

    // $cmb_group->add_field(array(
    //     'name' => esc_html__('Upload Dokumen', 'text-domain'),
    //     'id'   => 'dokumen',
    //     'type' => 'file',
    //     'query_args' => array(
    //         'type' => array(
    //             'application/pdf',
    //         ),
    //     ),
    // ));
}

function get_users_options()
{
    $users = get_users(array('fields' => array('ID', 'user_login')));
    $user_options = array();

    // tampilkan semua user jika administrator
    if (current_user_can('administrator')) {
        foreach ($users as $user) {
            $user_options[$user->ID] = $user->user_login;
        }
    } else {
        $user_options[get_current_user_id()] = get_userdata(get_current_user_id())->user_login;
    }



    return $user_options;
}


add_action('cmb2_admin_init', 'register_user_profile_metabox');
function register_user_profile_metabox()
{

    /**
     * Metabox for the user profile screen
     */
    $cmb_user = new_cmb2_box(array(
        'id'               => 'user_edit',
        'title'            => esc_html__('User Profile Metabox', 'cmb2'), // Doesn't output for user boxes
        'object_types'     => array('user'), // Tells CMB2 to use user_meta vs post_meta
        'show_names'       => true,
        'new_user_section' => 'add-new-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
    ));

    $cmb_user->add_field(array(
        'name' => esc_html__('Jabatan', 'cmb2'),
        'desc' => esc_html__('', 'cmb2'),
        'id'   => 'jabatan',
        'type'    => 'select',
        'options' => array(
            'Notaris' => esc_html__('Notaris', 'cmb2'),
            'PPAT (Pejabat Pembuat Akta Tanah)' => esc_html__('PPAT (Pejabat Pembuat Akta Tanah)', 'cmb2'),
            'Staff Notaris' => esc_html__('Staff Notaris', 'cmb2'),
            'Pegawai Administrasi' => esc_html__('Pegawai Administrasi', 'cmb2'),
            'Staff Keuangan' => esc_html__('Staff Keuangan', 'cmb2'),
            // 'Pengacara atau Legal Consultant' => esc_html__('Pengacara atau Legal Consultant', 'cmb2'),
        ),
    ));
    $cmb_user->add_field(array(
        'name' => esc_html__('Status', 'cmb2'),
        'desc' => esc_html__('', 'cmb2'),
        'id'   => 'status',
        'type'    => 'select',
        'options' => array(
            '' => esc_html__('-', 'cmb2'),
            'Aktif' => esc_html__('Aktif', 'cmb2'),
            'Non Aktif' => esc_html__('Non Aktif', 'cmb2'),
        ),
    ));
}

// Pastikan bahwa CMB2 sudah diinstal dan diaktifkan di situs Anda

// Fungsi untuk menambahkan meta box pada post type 'draft_kerja'
function add_customer_data_metabox()
{
    $prefix = '_customer_data_';
    $current_user = wp_get_current_user();
    $jabatan_staff = get_user_meta($current_user->ID, 'jabatan', true);
    $pelanggan_banks = get_option('pelanggan_bank', []);
    foreach ($pelanggan_banks as $value) {
        $pelanggan_bank[$value] = $value;
    }
    $pelanggan_pekerjaan = [];
    $pelanggan_pekerjaans = get_option('pelanggan_pekerjaan', []);
    foreach ($pelanggan_pekerjaans as $value) {
        $pelanggan_pekerjaan[$value] = $value;
    }


    $cmb = new_cmb2_box(array(
        'id'           => 'customer_data_metabox',
        'title'        => __('Data Konsumen', 'textdomain'),
        'object_types' => array('data_pelanggan'), // Post type yang diinginkan
        'context'      => 'normal',
        'priority'     => 'high',
    ));

    // Field Nama Lengkap
    $cmb->add_field(array(
        'name' => 'Nama Lengkap',
        'id'   => $prefix . 'nama_lengkap',
        'type' => 'text',
    ));

    // Field Alamat
    $cmb->add_field(array(
        'name' => 'Alamat',
        'id'   => $prefix . 'alamat',
        'type' => 'textarea_small',
    ));

    // Field WhatsApp
    $cmb->add_field(array(
        'name' => 'WhatsApp',
        'id'   => $prefix . 'whatsapp',
        'type' => 'text',
    ));

    // Kategori field
    $cmb->add_field(array(
        'name'    => __('Kategori', 'cmb2'),
        'desc'    => __('', 'cmb2'),
        'id'      => $prefix . 'kategori',
        'type'    => 'select',
        'options' => array(
            'Pribadi' => __('Pribadi', 'cmb2'),
            'Bank'    => __('Bank', 'cmb2'),
        ),
    ));

    // Bank field (hidden by default)
    $cmb->add_field(array(
        'name'    => __('Bank', 'cmb2'),
        'desc'    => __('', 'cmb2'),
        'id'      => $prefix . 'bank',
        'type'    => 'select',
        'options' => $pelanggan_bank,
        // 'attributes' => array(
        //     'style' => 'display:none;', // Hide the field initially
        // ),
    ));

    // =======================================================================

    $loops = ['', '2', '3', '4'];
    foreach ($loops as $loop) {
        $cmb->add_field(array(
            'name'    => __('Pekerjaan ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'pekerjaan' . $loop,
            'type'    => 'select',
            'options' => $pelanggan_pekerjaan,
            'attributes' => array(
                'data-loop' => $loop,
            ),
        ));

        $cmb->add_field(array(
            'name'    => __('Judul Akta ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'judul_akta' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Perjanjian_Kredit' . $loop . ' Pendirian_PT Pendirian_CV' . $loop . ' Pendirian_yayasan' . $loop . ' Pendirian_PT_perorangan' . $loop . ' Perubahan_PT Perub_CV' . $loop . ' Perub_Yayasan' . $loop . ' Perubahan_PT_perorangan' . $loop . '',
            ),
        ));

        $cmb->add_field(array(
            'name'    => __('Nomor Akta ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nomor_akta' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Perjanjian_Kredit' . $loop . ' Skmht' . $loop . ' Apht' . $loop . ' Fidusia' . $loop . ' Jual_beli' . $loop . ' Hibah' . $loop . ' Pendirian_PT' . $loop . ' Pendirian_CV' . $loop . ' Pendirian_yayasan' . $loop . ' Pendirian_PT_perorangan' . $loop . ' Perubahan_PT' . $loop . ' Perub_CV' . $loop . ' Perub_Yayasan' . $loop . ' Perubahan_PT_perorangan' . $loop . '',
            ),
        ));

        $cmb->add_field(array(
            'name'    => __('Tanggal Akta ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'tanggal_akta' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Perjanjian_Kredit' . $loop . ' Skmht' . $loop . ' Apht' . $loop . ' Fidusia' . $loop . ' Jual_beli Hibah Pendirian_P' . $loop . 'T Pendirian_CV' . $loop . ' Pendirian_yayasan' . $loop . ' Pendirian_PT_perorangan' . $loop . ' Perubahan_PT' . $loop . ' Perub_CV' . $loop . ' Perub_Yayasan' . $loop . ' Perubahan_PT_perorangan' . $loop . '',
                'type' => 'date',
                'autocomplete' => 'off',
            ),
        ));

        $cmb->add_field(array(
            'name'    => __('Yang Mengerjakan ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'yang_mengerjakan ' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Perjanjian_Kredit' . $loop . '',
            ),
        ));

        $cmb->add_field(array(
            'name'    => __('Jumlah Pinjaman ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'jumlah_pinjaman ' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Perjanjian_Kredit' . $loop . '',
            ),
        ));

        $cmb->add_field(array(
            'name'    => __('Jumlah Pinjaman ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'jumlah_pinjaman' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Perjanjian_Kredit' . $loop . '',
            ),
        ));

        $cmb->add_field(array(
            'name'    => __('Lain - lain ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'lain_lain' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Perjanjian_Kredit' . $loop . ' Pendirian_yayasan' . $loop . ' Perub_Yayasan' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nomor Agunan ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nomor_agunan' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Skmht' . $loop . ' Apht' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('NIB ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nib' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Skmht' . $loop . ' Apht' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('NOP ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nop' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Skmht' . $loop . ' Apht' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('NOP ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nop' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Skmht' . $loop . ' Apht' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nama Pemilik Agunan ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nama_pemilik_agunan' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Skmht' . $loop . ' Apht' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Kode Sertifikat ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'kode_sertifikat' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Skmht' . $loop . ' Apht' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nomor Seri ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nomor_seri' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Skmht' . $loop . ' Apht' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Jumlah Pengikatan ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'jumlah_pengikatan' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Skmht' . $loop . ' Apht' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Jenis Agunan ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'jenis_agunan' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Fidusia' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Keterangan Objek ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'keterangan_objek' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Fidusia' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Bukti Kepemilikan Objek ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'bukti_kepemilikan_objek' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Fidusia' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nilai Objek ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nilai_objek' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Fidusia' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Pemilik Agunan ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'pemilik_agunan' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Fidusia' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nilai Penjaminan ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nilai_penjaminan' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Fidusia' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('NPWP ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'npwp' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Fidusia' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Tanggal Habis SKMHT ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'tanggal_habis_skmht' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Skmht' . $loop . ' Fidusia' . $loop . '',
                'type' => 'date',
                'autocomplete' => 'off',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nama Penjual ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nama_penjual' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Jual_beli' . $loop . ' Hibah' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nama Pembeli ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nama_pembeli' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Jual_beli' . $loop . ' Hibah' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Sertifikat ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'sertifikat_saya' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Jual_beli' . $loop . ' Hibah' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Lokasi Tanah ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'lokasi_tanah' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Jual_beli' . $loop . ' Hibah' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nilai Jual Beli ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nilai_jual_beli' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Jual_beli' . $loop . ' Hibah' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nilai SSB ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nilai_ssb' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Jual_beli' . $loop . ' Hibah' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nilai SSP ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nilai_ssp' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Jual_beli' . $loop . ' Hibah' . $loop . '',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Keterangan PPJB ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'keterangan_ppjb_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Jual_beli' . $loop . ' Hibah' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Keterangan Kuasa Menjual ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'keterangan_kuasa_menjual_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Jual_beli' . $loop . ' Hibah' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Harga Real ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'harga_real_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Jual_beli' . $loop . ' Hibah' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Harga Kesepakatan ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'harga_kesepakatan_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Jual_beli' . $loop . ' Hibah' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Tanggal Masuk Berkas ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'tanggal_masuk_berkas_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Turun_waris' . $loop . ' Pecah' . $loop,
                'type' => 'date',
                'autocomplete' => 'off',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Pewaris ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'pewaris_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Turun_waris' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Ahli Waris ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'ahli_waris_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Turun_waris' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Penerima Waris ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'penerima_waris_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Turun_waris' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Lokasi Waris ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'lokasi_waris_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Turun_waris' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nilai Pajak ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nilai_pajak_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Turun_waris' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Berkas Kembali ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'berkas_kembali_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Turun_waris' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Masuk BPN ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'masuk_bpn_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Turun_waris' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Tanggal Akad ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'tanggal_akad_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Turun_waris' . $loop,
                'type' => 'date',
                'autocomplete' => 'off',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nama Pemilik Sertifikat ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nama_pemilik_sertifikat_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pecah' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Jumlah Pecah ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'jumlah_pecah_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pecah' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Keterangan Agunan ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'keterangan_agunan_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pecah' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Keterangan Berkas ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'keterangan_berkas_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pecah' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Tanggal Masuk BPN ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'tanggal_masuk_bpn_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pecah' . $loop,
                'type' => 'date',
                'autocomplete' => 'off',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nama Direktur ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nama_direktur_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pendirian_PT' . $loop . ' Pendirian_PT_perorangan' . $loop . ' Perubahan_PT' . $loop . ' Perubahan_PT_perorangan' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nama Komisaris ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nama_komisaris_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pendirian_PT' . $loop . ' Perubahan_PT' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nama Persero Aktif ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nama_persero_aktif_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pendirian_CV' . $loop . ' Perub_CV' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nama Persero Pasif ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nama_persero_pasif_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pendirian_CV' . $loop . ' Perub_CV' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nama Pembina ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nama_pembina_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pendirian_yayasan' . $loop . ' Perub_Yayasan' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nama Ketua ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nama_ketua_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pendirian_yayasan' . $loop . ' Perub_Yayasan' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nama Wakil ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nama_wakil_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pendirian_yayasan' . $loop . ' Perub_Yayasan' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nama Bendahara ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nama_bendahara_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pendirian_yayasan' . $loop . ' Perub_Yayasan' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('NPWP Direktur ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'npwp_direktur_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pendirian_PT' . $loop . ' Pendirian_PT_perorangan' . $loop . ' Perubahan_PT' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('NPWP Komisaris ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'npwp_komisaris_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pendirian_PT' . $loop . ' Perubahan_PT' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('NPWP Persero Aktif ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'npwp_persero_aktif_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pendirian_CV' . $loop . ' Perub_CV' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('NPWP Persero Pasif ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'npwp_persero_pasif_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pendirian_CV' . $loop . ' Perub_CV' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('NPWP Yayasan ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'npwp_yayasan_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pendirian_yayasan' . $loop . ' Perub_Yayasan' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Nama Pemilik Manfaat ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'nama_pemilik_manfaat_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pendirian_PT' . $loop . ' Perubahan_PT' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Kedudukan PT ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'kedudukan_pt_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pendirian_PT' . $loop . ' Pendirian_CV' . $loop . ' Pendirian_PT_perorangan' . $loop . ' Perubahan_PT' . $loop . ' Perub_CV' . $loop . ' Perubahan_PT_perorangan' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Biaya ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'biaya_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pendirian_PT' . $loop . ' Pendirian_CV' . $loop . ' Pendirian_yayasan' . $loop . ' Pendirian_PT_perorangan' . $loop . ' Perubahan_PT' . $loop . ' Perub_CV' . $loop . ' Perub_Yayasan' . $loop . ' Perubahan_PT_perorangan' . $loop,
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Keterangan ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'keterangan_' . $loop,
            'type'    => 'textarea',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pendirian_PT' . $loop . ' Pendirian_CV' . $loop . ' Pendirian_yayasan' . $loop . ' Pendirian_PT_perorangan' . $loop . ' Perubahan_PT' . $loop . ' Perub_CV' . $loop . ' Perub_Yayasan' . $loop . ' Perubahan_PT_perorangan' . $loop,
                'rows' => '5',
            )
        ));

        $cmb->add_field(array(
            'name'    => __('Tanggal Upload ' . $loop, 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'tanggal_upload_' . $loop,
            'type'    => 'text',
            'attributes' => array(
                'class' => 'opsi-pekerjaan' . $loop . ' form-control Pendirian_PT' . $loop . ' Pendirian_CV' . $loop . ' Pendirian_yayasan' . $loop . ' Pendirian_PT_perorangan' . $loop . ' Perubahan_PT' . $loop . ' Perub_CV' . $loop . ' Perub_Yayasan' . $loop . ' Perubahan_PT_perorangan' . $loop,
                'type' => 'date',
                'autocomplete' => 'off',
            )
        ));
    }

    // =======================================================================

    $cmb->add_field(array(
        'name'    => __('Pekerjaan 2', 'cmb2'),
        'desc'    => __('', 'cmb2'),
        'id'      => $prefix . 'pekerjan_2',
        'type'    => 'select',
        'options' => $pelanggan_pekerjaan
    ));

    $cmb->add_field(array(
        'name'    => __('Pekerjaan Lainnya', 'cmb2'),
        'desc'    => __('', 'cmb2'),
        'id'      => $prefix . 'pekerjaan_lainnya',
        'type'    => 'text',
    ));

    $cmb->add_field(array(
        'name'    => __('Sertifikat', 'cmb2'),
        'desc'    => __('', 'cmb2'),
        'id'      => $prefix . 'sertifikat',
        'type'    => 'text',
    ));

    if (current_user_can('administrator') || $jabatan_staff == 'keuangan'):
        // $cmb->add_field(array(
        //     'name'    => __('Nilai Transaksi', 'cmb2'),
        //     'desc'    => __('', 'cmb2'),
        //     'id'      => $prefix . 'nilai_transaksi',
        //     'type'    => 'text',
        //     'attributes' => array('class' => 'format-rupiah form-control'),
        // ));

        $cmb->add_field(array(
            'name'    => __('Harga Real', 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'harga_real',
            'type'    => 'text',
            'attributes' => array('class' => 'format-rupiah form-control'),
        ));

        $cmb->add_field(array(
            'name'    => __('Harga Kesepakatan', 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'harga_kesepakatan',
            'type'    => 'text',
            'attributes' => array('class' => 'format-rupiah form-control'),
        ));

        $cmb->add_field(array(
            'name'    => __('Nilai BPHTB', 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'pajak_pembeli',
            'type'    => 'text',
            'attributes' => array('class' => 'format-rupiah form-control'),
        ));

        $cmb->add_field(array(
            'name'    => __('Nilai SSP', 'cmb2'),
            'desc'    => __('', 'cmb2'),
            'id'      => $prefix . 'pajak_penjual',
            'type'    => 'text',
            'attributes' => array('class' => 'format-rupiah form-control'),
        ));
    endif;
}

add_action('cmb2_init', 'add_customer_data_metabox');

// METABOX JOB DESK
add_action('cmb2_init', 'job_desk_metabox_metabox');
function job_desk_metabox_metabox()
{
    $user_id = $_GET['user_id'] ?? '';
    $prefix = '';
    // Buat metabox
    $cmb_group = new_cmb2_box(array(
        'id'            => 'job_desk_metabox',
        'title'         => esc_html__('Pekerjaan Details', 'text-domain'),
        'object_types'  => array('job_desk'), // Ganti 'post' dengan jenis postingan yang Anda inginkan
    ));

    $cmb_group->add_field(array(
        'name' => esc_html__('Judul Job Desk', 'text-domain'),
        'id'   => 'judul_job_desk',
        'type' => 'text',
    ));

    $draft_id = $_GET['draft_id'] ?? '';
    $cmb_group->add_field(array(
        'name'             => 'Draft Kerja',
        'id'               => 'job_desk_draft_kerja',
        'type'             => 'text',
        'default'          => $draft_id,
    ));

    $current_user_id = get_current_user_id();
    $cmb_group->add_field(array(
        'name'             => 'Staff',
        'id'               => 'job_desk_id_staff',
        'type' => 'select',
        'options_cb' => 'get_users_options', // Gunakan callback untuk mengisi opsi
        'default'          => $current_user_id,
    ));

    // Field Pilihan Pelanggan

    $cmb_group->add_field(array(
        'name'    => esc_html__('Kategori', 'text-domain'),
        'id'      => 'job_desk_kategori_select',
        'type'    => 'select',
        'options' => array(
            'Notaris' => esc_html__('Notaris', 'text-domain'),
            'PPAT' => esc_html__('PPAT', 'text-domain'),
            'Lainya' => esc_html__('Lainya', 'text-domain'),
            // Tambahkan opsi lain sesuai kebutuhan Anda
        ),

    ));

    // $cmb_group->add_field( array(
    //     'name' => esc_html__( 'Pilih Staff', 'text-domain' ),
    //     'id'   => 'user_list',
    //     'type' => 'select',
    //     'options_cb' => 'get_users_options', // Gunakan callback untuk mengisi opsi
    // ) );

    $cmb_group->add_field(array(
        'name' => esc_html__('Tanggal Mulai', 'text-domain'),
        'id'   => 'job_desk_start',
        'type' => 'text_date',
        'attributes' => array(
            'autocomplete' => 'off',
        )
    ));

    $cmb_group->add_field(array(
        'name' => esc_html__('Tanggal Selesai', 'text-domain'),
        'id'   => 'job_desk_end',
        'type' => 'text_date',
        'attributes' => array(
            'autocomplete' => 'off',
        )
    ));

    $cmb_group->add_field(array(
        'name'    => esc_html__('Status', 'text-domain'),
        'id'      => 'job_desk_status',
        'type'    => 'select',
        'options' => array(
            '-' => esc_html__('-', 'text-domain'),
            'Pengerjaan' => esc_html__('Pengerjaan', 'text-domain'),
            'Selesai' => esc_html__('Selesai', 'text-domain'),
        ),
    ));
}

// METABOX DOKUMEN
add_action('cmb2_init', 'dokumen_metabox_metabox');
function dokumen_metabox_metabox()
{
    $user_id = $_GET['user_id'] ?? '';
    $prefix = '';
    $draft_kerja_id = $_GET['draft_kerja_id'] ?? '';

    // Buat metabox
    $cmb_group = new_cmb2_box(array(
        'id'            => 'dokumen_metabox',
        'title'         => esc_html__('Dokumen Details', 'text-domain'),
        'object_types'  => array('dokumen'), // Ganti 'post' denganenis postingan yang Anda inginkan
    ));

    // Field type post
    $cmb_group->add_field(array(
        'name' => esc_html__('', 'text-domain'),
        'id'   => 'id_order',
        'type' => 'hidden',
        'post_type' => 'draft_kerja',
        'default' => $draft_kerja_id,
        // 'attributes' => array('type' => 'format-rupiah form-control'),
    ));

    // Field nomor
    $cmb_group->add_field(array(
        'name'       => esc_html__('Nomor Akta', 'text-domain'),
        'id'         =>  'nomor_akta',
        'type'       => 'text',
        'attributes' => array(
            'type' => 'number',
            'min'  => 1,
        ),
    ));

    // Field Tanggal Akta
    $cmb_group->add_field(array(
        'name' => esc_html__('Tanggal Akta', 'text-domain'),
        'id'   => 'tanggal_akta',
        'type' => 'text_date',
        'attributes' => array(
            'type' => 'date',
            'autocomplete' => 'off',
        )
    ));

    // Jenis Akta
    $cmb_group->add_field(array(
        'name' => esc_html__('Jenis Akta', 'text-domain'),
        'id'   => 'jenis_akta',
        'type' => 'text',
    ));

    // Nama Penghadap
    $cmb_group->add_field(array(
        'name' => esc_html__('Nama Penghadap', 'text-domain'),
        'id'   => 'nama_penghadap',
        'type' => 'textarea',
    ));

    // Field Upload Dokumen
    $cmb_group->add_field(array(
        'name' => esc_html__('Upload Dokumen', 'text-domain'),
        'id'   => 'pdf',
        'type' => 'file',
        'query_args' => array(
            'type' => array(
                'application/pdf',
            ),
        ),
    ));
}

// METABOX UPLOAD BERKAS NOTARIS
// add_action('cmb2_init', 'upload_berkas_metabox');
// function job_desk_metabox_metabox()
// {
//  $cmb->add_field(array(
//         'name'    => __('No', 'cmb2'),
//         'desc'    => __('', 'cmb2'),
//         'id'      => $prefix . 'no_akta',
//         'type'    => 'text',
//     ));

// $cmb_group->add_field(array(
//         'name' => esc_html__('Tanggal Akta', 'text-domain'),
//         'id'   => 'tanggal_akta',
//         'type' => 'text_date',
//     ));

//  $cmb->add_field(array(
//         'name'    => __('Jenis Akta', 'cmb2'),
//         'desc'    => __('', 'cmb2'),
//         'id'      => $prefix . 'jenis_akta',
//         'type'    => 'select',
//         'options' => array(
//             'Pilih Opsi' => __('Pilih Opsi', 'cmb2'),
//             'Skmht' => __('Skmht', 'cmb2'),
//             'Apht'  => __('Apht', 'cmb2'),
//             'Fidusia' => __('Fidusia', 'cmb2'),
//             'Jual_beli' => __('Jual_beli', 'cmb2'),
//             'Hibah' => __('Hibah', 'cmb2'),
//             'Turun waris' => __('Turun waris', 'cmb2'),
//             'Aphb' => __('Aphb', 'cmb2'),
//             'Pendirian PT' => __('Pendirian PT', 'cmb2'),
//             'Pendirian CV' => __('Pendirian CV', 'cmb2'),
//             'Pendirian yayasan' => __('Pendirian yayasan', 'cmb2'),
//             'Pendirian PT perorangan' => __('Pendirian PT perorangan', 'cmb2'),
//             'Pendirian akta cabang' => __('Pendirian akta cabang', 'cmb2'),
//             'Perubahan PT' => __('Perubahan PT', 'cmb2'),
//             'Perub CV' => __('Perub CV', 'cmb2'),
//             'Perub Yayasan' => __('Perub Yayasan', 'cmb2'),
//             'Pecah sertifikat' => __('Pecah sertifikat', 'cmb2'),
//             'Pengeringan' => __('Pengeringan', 'cmb2'),
//             'PBG' => __('PBG', 'cmb2'),
//             'Peningkatan Hak' => __('Peningkatan Hak', 'cmb2'),
//         )
//     ));

// Field Nama Penghadap
// $cmb->add_field(array(
//     'name' => 'Nama Penghadap',
//     'id'   => $prefix . 'nama_penghadap_akta',
//     'type' => 'textarea_small',
// ));

// $cmb_group->add_field(array(
//     'name' => esc_html__('Upload Dokumen', 'text-domain'),
//     'id'   => 'dokumen_akta',
//     'type' => 'file',
//     'query_args' => array(
//         'type' => array(
//             'application/pdf',
//             'size' => 10485760, // Set maximum file size (10 MB in bytes)
//             'preview_size' => 'thumbnail',
//         ),
//     ),
// ));


// }


// Add JavaScript to handle the conditional logic
add_action('cmb2_after_form', function () {
?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Function to check the selected category and toggle the bank field
            function toggleBankField() {
                var kategori = $('#_customer_data_kategori').val(); // Get the current value of kategori field
                if (kategori === 'Bank') {
                    // Show the bank field if 'Bank' is selected
                    $('#_customer_data_bank').closest('.cmb-row').show();
                    $('#_customer_data_pekerjan').closest('.cmb-row').hide();
                    $('#_customer_data_pekerjan_2').closest('.cmb-row').hide();
                    $('#_customer_data_pekerjaan_lainnya').closest('.cmb-row').hide();
                } else {
                    // Hide the bank field if any other option is selected
                    $('#_customer_data_bank').closest('.cmb-row').hide();
                    $('#_customer_data_pekerjan').closest('.cmb-row').show();
                    $('#_customer_data_pekerjan_2').closest('.cmb-row').show();
                    $('#_customer_data_pekerjaan_lainnya').closest('.cmb-row').show();
                }
            }

            // Call toggleBankField on page load
            toggleBankField();

            // Add change event handler for kategori field
            $('#_customer_data_kategori').on('change', function() {
                toggleBankField();
            });


            // Add change event handler for pekerjaan field
            <?php
            $loops = ['', 2, 3, 4];
            foreach ($loops as $loop) : ?>
                $('.opsi-pekerjaan<?php echo $loop; ?> ').closest('.cmb-row').hide();
                $('#_customer_data_pekerjaan<?php echo $loop; ?>').on('change', function() {
                    var value = $(this).val().replace(/\s+/g, '_');
                    var dataLoop = $(this).attr('data-loop');
                    console.log(value);
                    console.log('.' + value + dataLoop);
                    $('.opsi-pekerjaan<?php echo $loop; ?> ').closest('.cmb-row').hide();
                    $('.' + value + dataLoop).closest('.cmb-row').show();
                });

            <?php endforeach; ?>
        });
    </script>
<?php
});
