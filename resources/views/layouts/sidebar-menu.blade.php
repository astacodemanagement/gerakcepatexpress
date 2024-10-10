<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
    <input type="hidden" class="form-control" id="cabang_id" name="cabang_id" value="{{ auth()->user()->cabang_id }}">
    <input type="hidden" class="form-control" id="id" name="id" value="{{ auth()->user()->id }}">
    {{-- <li class="nav-item menu-open"> --}}
    <li class="nav-item">
        <a href="/" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                Dashboard
            </p>
        </a>
    </li>

    @hasrole('superadmin')
        {{-- <li class="nav-header">Master</li> --}}
        <li class="nav-item{{ Route::is('profil.*') || Route::is('konsumen.*') || Route::is('kota.*') || Route::is('cabang.*') || Route::is('pengguna.*') ? ' menu-is-opening menu-open' : '' }}" id="data-master-menu">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Data Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/profil" class="nav-link {{ Route::is('profil.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Profil
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/konsumen" class="nav-link {{ Route::is('konsumen.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-handshake"></i>
                        <p>
                            Konsumen
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/kota" class="nav-link {{ Route::is('kota.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-store"></i>
                        <p>
                            Kota
                        </p>
                    </a>
                </li>
        
                <li class="nav-item">
                    <a href="/cabang" class="nav-link {{ Route::is('cabang.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-code-branch"></i>
                        <p>
                            Cabang
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/pengguna" class="nav-link {{ Route::is('pengguna.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Pengguna
                        </p>
                    </a>
                </li>
            </ul>
        </li>
     

        {{-- <li class="nav-header">Transaksi Gudang</li> --}}
        <li class="nav-item{{ Route::is('booking.*') || Route::is('pengambilan.*') || Route::is('ambil-pembatalan.*') || Route::is('barang_turun.*') ? ' menu-is-opening menu-open' : '' }}">
           
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-barcode"></i>
              <p>
                Transaksi Gudang
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('booking.index') }}" class="nav-link {{ Route::is('booking.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Booking
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pengambilan.index') }}" class="nav-link {{ Route::is('pengambilan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-export"></i>
                        <p>
                            Pengambilan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ambil-pembatalan.index') }}" class="nav-link {{ Route::is('ambil-pembatalan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-ban"></i>
                        <p>
                            Ambil Pembatalan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('barang_turun.index') }}" class="nav-link {{ Route::is('barang_turun.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-download"></i>
                        <p>
                            Barang Turun
                        </p>
                    </a>
                </li>
            </ul>
        </li>

      
      

        {{-- <li class="nav-header">Transaksi Kasir</li> --}}
        <li class="nav-item{{Route::is('pengiriman.*') || Route::is('penerimaan.*') || Route::is('pengeluaran.*') || Route::is('pembatalan.*') ? ' menu-is-opening menu-open' : '' }}">
           
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>
                Transaksi Kasir
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                
                <li class="nav-item">
                    <a href="{{ route('pengiriman.index') }}" class="nav-link {{ Route::is('pengiriman.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>Pengiriman Barang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('penerimaan.index') }}" class="nav-link {{ Route::is('penerimaan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-car"></i>
                        <p>Penerimaan Barang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pengeluaran.index') }}" class="nav-link {{ Route::is('pengeluaran.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-export"></i>
                        <p>Expend/Pengeluaran</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pembatalan.index') }}" class="nav-link {{ Route::is('pembatalan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-eject"></i>
                        <p>Pembatalan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ubah_pengiriman.index') }}" class="nav-link {{ Route::is('ubah_pengiriman.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>Ubah Pengiriman</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item{{ Route::is('invoice.generate') || Route::is('invoice.index') ? ' menu-is-opening menu-open' : '' }}">
          
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-landmark"></i>
              <p>
                Transaksi Finance
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                  {{-- <li class="nav-header">Transaksi Tagihan</li> --}}
                <li class="nav-item">
                    <a href="{{ route('invoice.generate') }}" class="nav-link {{ Route::is('invoice.generate') ? 'active' : '' }}">
                        <i class="fas fa-receipt nav-icon"></i>
                        <p>Buat Invoice</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('invoice.index') }}" class="nav-link {{ Route::is('invoice.index') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice-dollar nav-icon"></i>
                        <p>Invoice</p>
                    </a>
                </li>
            </ul>
        </li>

        
        {{-- <li class="nav-header">Transaksi Pembatalan</li> --}}
        <li class="nav-item">
            <a href="/verifikasi_pembatalan" class="nav-link {{ Route::is('verifikasi-pembatalan.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-strikethrough"></i>
                <p>Verifikasi Pembatalan</p>
            </a>
        </li>



      
        {{-- <li class="nav-header">Laporan</li> --}}
        <li class="nav-item{{ Route::is('data_penerimaan') || Route::is('data_pengiriman') || Route::is('lap_daftar_muat_detail.index_daftar_muat_detail') || Route::is('lap_daftar_muat_summary.index_daftar_muat_summary') || Route::is('lap_bongkar_detail.index_bongkar_detail') || Route::is('lap_bongkar_summary.index_bongkar_summary') || Route::is('lap_kasir_detail.index_kasir_detail') || Route::is('lap_kasir_summary.index_kasir_summary') || Route::is('lap_all_summary.index_all_summary') || Route::is('lap_pengeluaran.index') || Route::is('lap_pendapatan.index_pendapatan') || Route::is('lap_transferan.index_transferan') ? ' menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Data Laporan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('data_penerimaan') }}" class="nav-link {{ Route::is('data_penerimaan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            List Penerimaan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('data_pengiriman') }}" class="nav-link {{ Route::is('data_pengiriman') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            List Pengiriman
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('data_belum_ambil') }}" class="nav-link {{ Route::is('data_belum_ambil') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            List Belum Ambil
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="lap_daftar_muat_detail" class="nav-link {{ Route::is('lap_daftar_muat_detail.index_daftar_muat_detail') ? 'active' : '' }}">
                    
                        <i class="nav-icon fas fa-file"></i>
                        <p>Lap. Daftar Muat Det</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="lap_daftar_muat_summary" class="nav-link {{ Route::is('lap_daftar_muat_summary.index_daftar_muat_summary') ? 'active' : '' }}">
                    
                        <i class="nav-icon fas fa-file"></i>
                        <p>Lap. Daftar Muat Sum</p>
                    </a>
                </li>
                <li class="nav-item">
                        <a href="lap_bongkar_detail" class="nav-link {{ Route::is('lap_bongkar_detail.index_bongkar_detail') ? 'active' : '' }}">
                  
                        <i class="nav-icon fas fa-file"></i>
                        <p>Lap. Bongkar Det</p>
                    </a>
                </li>
                <li class="nav-item">
                        <a href="lap_bongkar_summary" class="nav-link {{ Route::is('lap_bongkar_summary.index_bongkar_summary') ? 'active' : '' }}">
                  
                        <i class="nav-icon fas fa-file"></i>
                        <p>Lap. Bongkar Sum</p>
                    </a>
                </li>
                <li class="nav-item">
                
                        <a href="lap_kasir_detail" class="nav-link {{ Route::is('lap_kasir_detail.index_kasir_detail') ? 'active' : '' }}">
                  
                        <i class="nav-icon fas fa-file"></i>
                        <p>Lap. Kasir Detail</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="lap_kasir_summary" class="nav-link {{ Route::is('lap_kasir_summary.index_kasir_summary') ? 'active' : '' }}">
                  
                        <i class="nav-icon fas fa-file"></i>
                        <p>Lap. Kasir Sum</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="lap_all_summary" class="nav-link {{ Route::is('lap_all_summary.index_all_summary') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Lap. Summary All</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="lap_pengeluaran" class="nav-link {{ Route::is('lap_pengeluaran.index') ? 'active' : '' }}">
              
                    <i class="nav-icon fas fa-file"></i>
                    <p>Laporan Pengeluaran</p>
                </a>
                </li>
                <li class="nav-item">
                    <a href="lap_pendapatan" class="nav-link {{ Route::is('lap_pendapatan.index_pendapatan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Laporan Pendapatan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="lap_transferan" class="nav-link {{ Route::is('lap_transferan.index_transferan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Laporan Transferan</p>
                    </a>
                </li>
            </ul>
        </li>


       

    @endhasrole

    @hasrole('gudang')
        <li class="nav-item">
            <a href="{{ route('booking.index') }}" class="nav-link {{ Route::is('booking.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-book"></i>
                <p>
                    Booking
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pengambilan.index') }}" class="nav-link {{ Route::is('pengambilan.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file-export"></i>
                <p>
                    Pengambilan
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('ambil-pembatalan.index') }}" class="nav-link {{ Route::is('ambil-pembatalan.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-ban"></i>
                <p>
                    Ambil Pembatalan
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('barang_turun.index') }}" class="nav-link {{ Route::is('barang_turun.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-download"></i>
                <p>
                    Barang Turun
                </p>
            </a>
        </li>
       
    @endhasrole

    @hasrole('kasir')

        <li class="nav-item">
            <a href="{{ route('pengiriman.index') }}" class="nav-link {{ Route::is('pengiriman.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-truck"></i>
                <p>Pengiriman Barang</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('penerimaan.index') }}" class="nav-link {{ Route::is('penerimaan.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-car"></i>
                <p>Penerimaan Barang</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pengeluaran.index') }}" class="nav-link {{ Route::is('pengeluaran.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file-export"></i>
                <p>Expend/Pengeluaran</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pembatalan.index') }}" class="nav-link {{ Route::is('pembatalan.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-eject"></i>
                <p>Pembatalan</p>
            </a>
        </li>
        <li class="nav-header">Laporan</li>
          <li class="nav-item">
            <a href="{{ route('data_penerimaan') }}" class="nav-link {{ Route::is('data_penerimaan') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file"></i>
                <p>
                    List Penerimaan
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('data_pengiriman') }}" class="nav-link {{ Route::is('data_pengiriman') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file"></i>
                <p>
                    List Pengiriman
                </p>
            </a>
        </li>
        <li class="nav-item">
        
            <a href="lap_kasir_detail" class="nav-link {{ Route::is('lap_kasir_detail.index_kasir_detail') ? 'active' : '' }}">
      
            <i class="nav-icon fas fa-file"></i>
            <p>Lap. Kasir Detail</p>
        </a>
        </li>
        <li class="nav-item">
            <a href="lap_kasir_summary" class="nav-link {{ Route::is('lap_kasir_summary.index_kasir_summary') ? 'active' : '' }}">
        
                <i class="nav-icon fas fa-file"></i>
                <p>Lap. Kasir Sum</p>
            </a>
        </li>
    @endhasrole

    @hasrole('manager')
        <li class="nav-item">
            <a href="/verifikasi_pembatalan" class="nav-link {{ Route::is('verifikasi-pembatalan.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-strikethrough"></i>
                <p>Verifikasi Pembatalan</p>
                <span class="badge bg-danger">1</span>
            </a>
        </li>
        <li class="nav-header">Laporan</li>
        <li class="nav-item">
            <a href="{{ route('data_belum_ambil') }}" class="nav-link {{ Route::is('data_belum_ambil') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file"></i>
                <p>
                    List Belum Ambil
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="lap_daftar_muat_detail" class="nav-link {{ Route::is('lap_daftar_muat_detail.index_daftar_muat_detail') ? 'active' : '' }}">
            
                <i class="nav-icon fas fa-file"></i>
                <p>Lap. Daftar Muat Det</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="lap_daftar_muat_summary" class="nav-link {{ Route::is('lap_daftar_muat_summary.index_daftar_muat_summary') ? 'active' : '' }}">
            
                <i class="nav-icon fas fa-file"></i>
                <p>Lap. Daftar Muat Sum</p>
            </a>
        </li>
        <li class="nav-item">
                <a href="lap_bongkar_detail" class="nav-link {{ Route::is('lap_bongkar_detail.index_bongkar_detail') ? 'active' : '' }}">
          
                <i class="nav-icon fas fa-file"></i>
                <p>Lap. Bongkar Det</p>
            </a>
        </li>
        <li class="nav-item">
                <a href="lap_bongkar_summary" class="nav-link {{ Route::is('lap_bongkar_summary.index_bongkar_summary') ? 'active' : '' }}">
          
                <i class="nav-icon fas fa-file"></i>
                <p>Lap. Bongkar Sum</p>
            </a>
        </li>
    @endhasrole

    @hasrole('finance')
        <li class="nav-item">
            <a href="{{ route('pengeluaran.index') }}" class="nav-link {{ Route::is('pengeluaran.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file-export"></i>
                <p>Expend/Pengeluaran</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('invoice.generate') }}" class="nav-link {{ Route::is('invoice.generate') ? 'active' : '' }}">
                <i class="fas fa-receipt nav-icon"></i>
                <p>Buat Invoice</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('invoice.index') }}" class="nav-link {{ Route::is('invoice.index') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar nav-icon"></i>
                <p>Invoice</p>
            </a>
        </li>
        <li class="nav-header">Laporan</li>
        <li class="nav-item">
            <a href="lap_pengeluaran" class="nav-link {{ Route::is('lap_pengeluaran.index') ? 'active' : '' }}">
      
                <i class="nav-icon fas fa-file"></i>
                <p>Laporan Pengeluaran</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="lap_transferan" class="nav-link {{ Route::is('lap_transferan.index_transferan') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file"></i>
                <p>Laporan Transferan</p>
            </a>
        </li>
    @endhasrole
</ul>
