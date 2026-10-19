<?php
// Central Data Properti RumahKita

function get_all_properti() {
    return [
        1 => [
            'id' => 1,
            'kode' => 'RK-001',
            'nama' => 'Grand Royal Mansion Jagakarsa',
            'kategori' => 'villa',
            'tipe_label' => 'Villa Modern',
            'lokasi_singkat' => 'Jakarta Selatan',
            'alamat_lengkap' => 'Jl. Margasatwa Barat No. 48, Jagakarsa, Jakarta Selatan, DKI Jakarta 12620',
            'harga' => 1450000000,
            'harga_format' => 'Rp 1.450.000.000',
            'badges' => ['Unggulan', 'SHM', 'Siap Huni'],
            'kt' => 4,
            'km' => 3,
            'luas_bangunan' => 180,
            'luas_tanah' => 200,
            'carport' => 2,
            'lantai' => 2,
            'listrik' => '3.500 Watt',
            'air' => 'PDAM & Sumur Bor Jetpump',
            'sertifikat' => 'Sertifikat Hak Milik (SHM) & PBG/IMB',
            'kondisi' => 'Semi Furnished (Kitchen Set Mewah)',
            'tahun_dibangun' => 2023,
            'arah_hadap' => 'Selatan',
            'foto_utama' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1200&q=80',
            'galeri' => [
                'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600566753376-12c8ab7fb75b?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600573472591-ee6b68d14c68?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80'
            ],
            'deskripsi' => 'Grand Royal Mansion Jagakarsa mempersembahkan hunian premium bernuansa resort mewah di tengah ketenangan Jakarta Selatan. Dirancang khusus bagi Anda yang mengutamakan privasi, kemewahan estetika, dan sirkulasi udara alami yang segar. Dilengkapi kolam renang pribadi di halaman belakang, ruang keluarga berpintu kaca lipat, dan master bedroom elegan dengan walk-in closet. Lokasi sangat prima hanya selangkah ke kawasan perkantoran TB Simatupang serta akses tol Desari yang mempermudah mobilitas harian Anda.',
            'fasilitas' => [
                'Kolam Renang Pribadi (Private Pool)',
                'One Gate System & Security 24 Jam',
                'Smart Digital Door Lock & Kamera CCTV',
                'Master Bedroom dengan En-suite Bathroom',
                'Kitchen Set Modern & Meja Marmer',
                'Taman Belakang Hijau & Area BBQ',
                'Row Jalan Kompleks 8 Meter (2 Arah)',
                'Jaringan Kabel Listrik Bawah Tanah',
                'Bebas Banjir Terverifikasi'
            ],
            'akses' => [
                ['waktu' => '5 Menit', 'tujuan' => 'Pintu Gerbang Tol Brigif / Desari'],
                ['waktu' => '7 Menit', 'tujuan' => 'Stasiun KRL Lenteng Agung'],
                ['waktu' => '10 Menit', 'tujuan' => 'Cilandak Town Square & Koridor TB Simatupang'],
                ['waktu' => '12 Menit', 'tujuan' => 'RSUD Pasar Minggu & RS Siloam'],
                ['waktu' => '15 Menit', 'tujuan' => 'Kawasan Pendidikan Universitas Indonesia']
            ],
            'denah' => [
                'Lantai 1' => 'Carport 2 Mobil, Teras Depan, Ruang Tamu & Keluarga Konsep Terbuka, Dapur Bersih + Kitchen Island, Kamar Tamu, Kamar Mandi, Area Cuci Jemur, Taman + Kolam Renang Privat.',
                'Lantai 2' => 'Master Bedroom dengan Kamar Mandi Dalam & Balkon, 2 Kamar Tidur Anak, 1 Kamar Mandi Luar, Ruang Kerja / Santai Keluarga.'
            ],
            'agen' => [
                'nama' => 'Budi Santoso, S.T.',
                'peran' => 'Konsultan Spesialis Jakarta Selatan',
                'telepon' => '6281234567890',
                'rating' => '4.9/5.0 (52 Ulasan)',
                'pengalaman' => '8 Tahun Pengalaman',
                'foto' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=256&q=80'
            ]
        ],
        2 => [
            'id' => 2,
            'kode' => 'RK-002',
            'nama' => 'Skyline Terrace Residence',
            'kategori' => 'minimalis',
            'tipe_label' => 'Rumah Minimalis',
            'lokasi_singkat' => 'BSD City, Tangerang',
            'alamat_lengkap' => 'Cluster Skyline Terrace Blok C-12, BSD City, Tangerang, Banten 15345',
            'harga' => 875000000,
            'harga_format' => 'Rp 875.000.000',
            'badges' => ['Siap Huni', 'Free BPHTB', 'Promo KPR'],
            'kt' => 3,
            'km' => 2,
            'luas_bangunan' => 110,
            'luas_tanah' => 120,
            'carport' => 2,
            'lantai' => 2,
            'listrik' => '2.200 Watt',
            'air' => 'PDAM Mandiri BSD',
            'sertifikat' => 'Sertifikat Hak Milik (SHM)',
            'kondisi' => 'Baru Gress (Siap Huni)',
            'tahun_dibangun' => 2024,
            'arah_hadap' => 'Timur',
            'foto_utama' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=80',
            'galeri' => [
                'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600121848594-d8644e57abab?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600573472550-8090b5e0745e?auto=format&fit=crop&w=1200&q=80'
            ],
            'deskripsi' => 'Skyline Terrace Residence menghadirkan konsep Scandinavian Modern yang mengedepankan efisiensi ruang, pencahayaan alami yang melimpah, dan material ramah lingkungan. Dilengkapi sistem ventilasi silang yang sejuk serta plafon tinggi 3,8 meter yang memberikan kesan lapang dan mewah. Terletak di jantung kota mandiri BSD City dengan akses cepat ke pusat perbelanjaan, sekolah internasional ternama, dan stasiun commuter line.',
            'fasilitas' => [
                'Smart Home Lighting & CCTV',
                'Canopy Carport Estetik Siap Pakai',
                'Clubhouse Kompleks dengan Kolam Renang & Gym',
                'Taman Bermain Anak (Children Playground)',
                'Sistem Keamanan 24 Jam dengan Kartu Akses',
                'Instalasi AC di Setiap Kamar Siap Pasang',
                'Taman Depan & Belakang Minimalis',
                'Jalur Pipa Gas Alam Perumahan'
            ],
            'akses' => [
                ['waktu' => '5 Menit', 'tujuan' => 'Pintu Tol Serpong - Balaraja'],
                ['waktu' => '6 Menit', 'tujuan' => 'Stasiun KRL Cisauk & Intermoda BSD'],
                ['waktu' => '8 Menit', 'tujuan' => 'AEON Mall BSD & ICE BSD City'],
                ['waktu' => '10 Menit', 'tujuan' => 'Eka Hospital & RS Medika BSD'],
                ['waktu' => '12 Menit', 'tujuan' => 'Universitas Prasetiya Mulya & Atma Jaya']
            ],
            'denah' => [
                'Lantai 1' => 'Carport 2 Mobil, Teras & Taman Depan, Ruang Tamu & Ruang Makan, 1 Kamar Tidur Bawah, 1 Kamar Mandi, Dapur Terbuka, Halaman Belakang.',
                'Lantai 2' => 'Kamar Tidur Utama dengan Jendela Lebar, 1 Kamar Tidur Anak, 1 Kamar Mandi Keluarga, Ruang Baca Keluarga.'
            ],
            'agen' => [
                'nama' => 'Rina Wijaya, S.E.',
                'peran' => 'Senior Property Consultant BSD & Serpong',
                'telepon' => '6281234567890',
                'rating' => '4.95/5.0 (68 Ulasan)',
                'pengalaman' => '7 Tahun Pengalaman',
                'foto' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=256&q=80'
            ]
        ],
        3 => [
            'id' => 3,
            'kode' => 'RK-003',
            'nama' => 'Emerald Garden Sentul City',
            'kategori' => 'cluster',
            'tipe_label' => 'Cluster Asri',
            'lokasi_singkat' => 'Sentul City, Bogor',
            'alamat_lengkap' => 'Jl. Boulevard Sentul Hijau No. 18, Sentul City, Babakan Madang, Bogor 16810',
            'harga' => 690000000,
            'harga_format' => 'Rp 690.000.000',
            'badges' => ['Promo KPR', 'One Gate', 'View Pegunungan'],
            'kt' => 2,
            'km' => 2,
            'luas_bangunan' => 85,
            'luas_tanah' => 96,
            'carport' => 1,
            'lantai' => 2,
            'listrik' => '2.200 Watt',
            'air' => 'PDAM Tirta Kahuripan',
            'sertifikat' => 'Sertifikat Hak Milik (SHM)',
            'kondisi' => 'Siap Huni (Furnitur Sebagian)',
            'tahun_dibangun' => 2023,
            'arah_hadap' => 'Utara',
            'foto_utama' => 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=1200&q=80',
            'galeri' => [
                'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600566752355-35792bedcfea?auto=format&fit=crop&w=1200&q=80'
            ],
            'deskripsi' => 'Nikmati udara perbukitan yang sejuk dan pemandangan hijau Gunung Pancar setiap hari di Emerald Garden Sentul City. Cluster eksklusif dengan keamanan tinggi, jalan lingkungan mulus, dan suasana asri bebas polusi. Cocok bagi Anda yang mendambakan kenyamanan hidup tenang tanpa kehilangan akses mudah ke ibu kota lewat Tol Jagorawi.',
            'fasilitas' => [
                'Panorama View Pegunungan Asri',
                'One Gate System & Pos Satpam 24 Jam',
                'Jogging Track di Bawah Pepohonan Rindang',
                'Clubhouse & Lapangan Bulutangkis',
                'Taman Komunitas Bersih & Nyaman',
                'Row Jalan Depan Rumah 7 Meter',
                'Suasana Tenang, Udara Dingin Segar'
            ],
            'akses' => [
                ['waktu' => '6 Menit', 'tujuan' => 'Pintu Keluar Tol Sentul Selatan / Jagorawi'],
                ['waktu' => '7 Menit', 'tujuan' => 'AEON Mall Sentul City & IKEA Sentul'],
                ['waktu' => '8 Menit', 'tujuan' => 'RS EMC Sentul City'],
                ['waktu' => '10 Menit', 'tujuan' => 'Taman Budaya Sentul & Wisata Kuliner'],
                ['waktu' => '15 Menit', 'tujuan' => 'Kawasan Pemandian Air Panas Gunung Pancar']
            ],
            'denah' => [
                'Lantai 1' => 'Carport 1 Mobil + Motor, Teras, Ruang Tamu Hangat, Dapur Bersih, 1 Kamar Mandi, Taman Belakang Terbuka.',
                'Lantai 2' => '2 Kamar Tidur Nyaman dengan Pencahayaan Alami, 1 Kamar Mandi, Balkon dengan Pemandangan Bukit Hijau.'
            ],
            'agen' => [
                'nama' => 'Hendra Setiawan',
                'peran' => 'Spesialis Properti Sentul & Bogor',
                'telepon' => '6281234567890',
                'rating' => '4.88/5.0 (41 Ulasan)',
                'pengalaman' => '6 Tahun Pengalaman',
                'foto' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=256&q=80'
            ]
        ],
        4 => [
            'id' => 4,
            'kode' => 'RK-004',
            'nama' => 'Bali Breeze Luxury Villa',
            'kategori' => 'villa',
            'tipe_label' => 'Villa Resort',
            'lokasi_singkat' => 'Canggu, Bali',
            'alamat_lengkap' => 'Jl. Pantai Batu Bolong Gang Kenanga No. 8, Canggu, Kuta Utara, Badung, Bali 80351',
            'harga' => 3250000000,
            'harga_format' => 'Rp 3.250.000.000',
            'badges' => ['Luxury', 'Full Furnished', 'High ROI'],
            'kt' => 4,
            'km' => 4,
            'luas_bangunan' => 260,
            'luas_tanah' => 320,
            'carport' => 2,
            'lantai' => 2,
            'listrik' => '7.700 Watt',
            'air' => 'PDAM Tirta Mangutama & Sumur Bor',
            'sertifikat' => 'Sertifikat Hak Milik (SHM) & Izin Pondok Wisata Lengkap',
            'kondisi' => 'Full Furnished Standar Resort Bintang 5',
            'tahun_dibangun' => 2023,
            'arah_hadap' => 'Barat Daya',
            'foto_utama' => 'https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=1200&q=80',
            'galeri' => [
                'https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600566753376-12c8ab7fb75b?auto=format&fit=crop&w=1200&q=80'
            ],
            'deskripsi' => 'Bali Breeze Luxury Villa adalah mahakarya properti tropis di destinasi paling bergengsi Canggu, Bali. Menawarkan kolam renang infinity bernuansa biru kristal, dek berjemur kayu ulin, dan konsep ruang tamu terbuka khas Bali yang menyatu dengan keindahan alam tropis. Sangat prospektif untuk tempat tinggal mewah pribadi sekaligus bisnis sewa vila harian berdaya okupansi tinggi (ROI rata-rata 14-18% per tahun).',
            'fasilitas' => [
                'Infinity Private Swimming Pool dengan Sun Deck',
                'Open-Air Living & Dining Pavilion Tropis',
                'Kamar Mandi Semi-Outdoor dengan Bathtub Batu Alami',
                'Perabotan Desainer Bali Lengkap (Turnkey Ready)',
                'Dapur Kering & Kitchen Bar Berbahan Kayu Jati',
                'Sistem Smart TV & Audio Terintegrasi',
                'Garasi & Ruang Staf Terpisah',
                'Izin Wisata Sah untuk Operasional Harian'
            ],
            'akses' => [
                ['waktu' => '5 Menit', 'tujuan' => 'Pantai Batu Bolong & Echo Beach Canggu'],
                ['waktu' => '5 Menit', 'tujuan' => 'Kawasan Kuliner & Kafe Hits Canggu'],
                ['waktu' => '15 Menit', 'tujuan' => 'Atlas Beach Fest & Finns Beach Club'],
                ['waktu' => '25 Menit', 'tujuan' => 'Kawasan Seminyak & Petitenget'],
                ['waktu' => '45 Menit', 'tujuan' => 'Bandara Internasional I Gusti Ngurah Rai']
            ],
            'denah' => [
                'Lantai 1' => 'Carport 2 Mobil, Ruang Terbuka Living & Dining Pavilion, Dapur Mewah, 2 Master Suite dengan En-suite Bathroom & Akses Langsung Kolam Renang, Sun Deck + Gazebo.',
                'Lantai 2' => '2 Kamar Tidur Mewah dengan Balkon Panorama Sawah Canggu, 2 Kamar Mandi Dalam, Ruang Santai Rooftop Sunset Lounge.'
            ],
            'agen' => [
                'nama' => 'Made Arya Dananjaya',
                'peran' => 'Head of Bali Luxury Property RumahKita',
                'telepon' => '6281234567890',
                'rating' => '5.0/5.0 (73 Ulasan)',
                'pengalaman' => '11 Tahun Pengalaman',
                'foto' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=256&q=80'
            ]
        ],
        5 => [
            'id' => 5,
            'kode' => 'RK-005',
            'nama' => 'Citra Harmoni Modern House',
            'kategori' => 'minimalis',
            'tipe_label' => 'Rumah Minimalis',
            'lokasi_singkat' => 'Sukolilo, Surabaya',
            'alamat_lengkap' => 'Perumahan Citra Harmoni Blok B4 No. 9, Sukolilo, Surabaya Timur, Jawa Timur 60111',
            'harga' => 540000000,
            'harga_format' => 'Rp 540.000.000',
            'badges' => ['Terlaris', 'SHM', 'Cicilan Ringan'],
            'kt' => 2,
            'km' => 1,
            'luas_bangunan' => 65,
            'luas_tanah' => 75,
            'carport' => 1,
            'lantai' => 1,
            'listrik' => '1.300 Watt',
            'air' => 'PDAM Surya Sembada Surabaya',
            'sertifikat' => 'Sertifikat Hak Milik (SHM)',
            'kondisi' => 'Siap Huni (Renovasi Baru)',
            'tahun_dibangun' => 2022,
            'arah_hadap' => 'Utara',
            'foto_utama' => 'https://images.unsplash.com/photo-1598228723793-52759bba239c?auto=format&fit=crop&w=1200&q=80',
            'galeri' => [
                'https://images.unsplash.com/photo-1598228723793-52759bba239c?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600566752355-35792bedcfea?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1600121848594-d8644e57abab?auto=format&fit=crop&w=1200&q=80'
            ],
            'deskripsi' => 'Hunian idaman bagi pasangan muda dan keluarga baru di kawasan berkembang Surabaya Timur. Memiliki tata ruang fungsional tanpa sekat yang membuat rumah terasa lega dan terang. Berada di lingkungan perumahan yang tertib, jalan paving lebar, bebas banjir, serta dekat dengan berbagai kampus ternama seperti ITS dan Unair.',
            'fasilitas' => [
                'Jalan Lingkungan Paving Rata Lebar 6 Meter',
                'Sistem Keamanan Portal Perumahan 24 Jam',
                'Taman Depan Asri & Carport Beratap',
                'Dapur Belakang Tertutup dengan Wastafel Baru',
                'Jaringan Air PDAM Lancar & Tandon Air Bawah Tanah',
                'Lingkungan Ramah Anak & Dekat Fasilitas Ibadah'
            ],
            'akses' => [
                ['waktu' => '5 Menit', 'tujuan' => 'Kampus ITS & Poltek Elektronika Negeri Surabaya'],
                ['waktu' => '7 Menit', 'tujuan' => 'Akses Jalan MERR (Middle East Ring Road)'],
                ['waktu' => '10 Menit', 'tujuan' => 'Galaxy Mall Surabaya & Pusat Perbelanjaan'],
                ['waktu' => '12 Menit', 'tujuan' => 'RS Onkologi & RS Haji Surabaya'],
                ['waktu' => '15 Menit', 'tujuan' => 'Jembatan Suramadu & Tol Juanda']
            ],
            'denah' => [
                'Lantai 1' => 'Carport Berkanopi, Teras Depan, Ruang Tamu & Keluarga Minimalis, 2 Kamar Tidur Nyaman, 1 Kamar Mandi, Dapur & Ruang Makan, Area Cuci Terbuka Belakang.'
            ],
            'agen' => [
                'nama' => 'Dewi Anggraini, S.Kom.',
                'peran' => 'Konsultan Properti Surabaya Timur',
                'telepon' => '6281234567890',
                'rating' => '4.91/5.0 (39 Ulasan)',
                'pengalaman' => '5 Tahun Pengalaman',
                'foto' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=256&q=80'
            ]
        ],
        6 => [
            'id' => 6,
            'kode' => 'RK-006',
            'nama' => 'Verde Heights Sky Residence',
            'kategori' => 'apartemen',
            'tipe_label' => 'Apartemen Mewah',
            'lokasi_singkat' => 'Dago Pakar, Bandung',
            'alamat_lengkap' => 'Verde Heights Tower A Lantai 16, Jl. Dago Pakar Raya No. 25, Ciburial, Bandung 40198',
            'harga' => 1150000000,
            'harga_format' => 'Rp 1.150.000.000',
            'badges' => ['Strata Title', 'Sky Lounge', 'View Kota'],
            'kt' => 2,
            'km' => 2,
            'luas_bangunan' => 78,
            'luas_tanah' => 78,
            'carport' => 1,
            'lantai' => 1,
            'listrik' => '3.500 Watt',
            'air' => 'PDAM Tirtawening Pengolahan Terpadu',
            'sertifikat' => 'Strata Title (SHM Sarusun Resmi)',
            'kondisi' => 'Full Furnished Desain Scandinavian',
            'tahun_dibangun' => 2023,
            'arah_hadap' => 'Pemandangan Kota Bandung (City View)',
            'foto_utama' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=80',
            'galeri' => [
                'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=1200&q=80'
            ],
            'deskripsi' => 'Verde Heights Sky Residence menawarkan sensasi tinggal di atas awan dengan pemandangan cakrawala Kota Bandung yang memukau. Berlokasi di kawasan sejuk dan prestisius Dago Pakar, apartemen ini menggabungkan kemewahan hidup urban dengan ketenangan udara pegunungan. Dilengkapi fasilitas setara hotel bintang 5 seperti infinity pool berpemanas, sky lounge, fitness center, dan lift berkecepatan tinggi dengan akses kartu pribadi.',
            'fasilitas' => [
                'Heated Infinity Pool Menghadap City Light Bandung',
                'Sky Lounge & Coworking Space Eksklusif di Rooftop',
                'Pusat Kebugaran / Fitness Center Lengkap',
                'Akses Kartu Lift Pribadi & Smart Lock',
                'Area Parkir Khusus Bawah Tanah (Dedicated Parking)',
                'Resepsionis & Layanan Concierge 24 Jam',
                'Balkon Luas Kaca Tempered Panorama Kota',
                'Kafe & Minimarket Terpadu di Lantai Ground'
            ],
            'akses' => [
                ['waktu' => '5 Menit', 'tujuan' => 'Kawasan Wisata Kuliner Dago Atas'],
                ['waktu' => '8 Menit', 'tujuan' => 'Dago Heritage Golf Course 1917'],
                ['waktu' => '12 Menit', 'tujuan' => 'Institut Teknologi Bandung (ITB) & UNPAD'],
                ['waktu' => '15 Menit', 'tujuan' => 'Rumah Sakit Borromeus Bandung'],
                ['waktu' => '20 Menit', 'tujuan' => 'Pintu Gerbang Tol Pasteur']
            ],
            'denah' => [
                'Unit Apartemen' => 'Foyer Depan, Ruang Tamu & Dining Area Mewah, Balkon Kaca dengan View Kota Bandung, Dapur Kering Modern Berbahan Granit, Master Bedroom dengan Kamar Mandi Dalam, 1 Kamar Tidur Anak/Kerja, 1 Kamar Mandi Tamu.'
            ],
            'agen' => [
                'nama' => 'Farhan Ramadhan, M.B.A.',
                'peran' => 'Spesialis Apartemen & Properti Premium Bandung',
                'telepon' => '6281234567890',
                'rating' => '4.96/5.0 (64 Ulasan)',
                'pengalaman' => '9 Tahun Pengalaman',
                'foto' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=256&q=80'
            ]
        ]
    ];
}

function get_properti_by_id($id) {
    $all = get_all_properti();
    $id = (int)$id;
    return $all[$id] ?? null;
}
