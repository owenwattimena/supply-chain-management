{{-- @php
    if(!in_array(auth()->user()->role, Config::get('constants.access.menu.master_user', []))){

    }
@endphp --}}

@extends('admin.templates.template')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('body')
<section class="content-header">
    <h1>
        Pengguna
        <small>Pengguna SCM</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-users"></i> Pengguna</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Pengguna</h3>
        </div>
        <div class="box-body">
            <button class="btn btn-flat bg-olive" style="margin-bottom: 15px" data-toggle="modal" data-target="#modal-default">TAMBAH</button>
            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{route('master.user.post')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Tambah Pengguna</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', '') }}" required placeholder="Masukan Nama">
                                    @error('name')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username', '') }}" required placeholder="Masukan Username">
                                    @error('username')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" value="{{ old('password', '') }}" required placeholder="Masukan Password">
                                    @error('password')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', '') }}" required placeholder="Masukan email">
                                @error('email')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div> --}}
                            <div class="form-group">
                                <label>Role</label>
                                <select id="role" class="form-control" name="role">
                                    {{-- <option value="developer">Developer</option> --}}
                                    {{-- <option value="superadmin">Superadmin</option> --}}
                                    <option value="admin">Admin</option>
                                    <option value="stockpile">Stockpile</option>
                                    <option value="stockpile_pasir">Stockpile Pasir</option>
                                    <option value="supplier">Supplier</option>
                                    <option value="supplier_pasir">Supplier Pasir</option>
                                    <option value="produksi">Produksi</option>
                                    <option value="manager">Manager</option>
                                    {{-- <option value="manager">Manager</option> --}}
                                </select>
                            </div>
                            {{-- if role supplier pasir --}}
                            <div class="form-group supplier_pasir">
                                <label for="no_plat">Nomor Plat</label>
                                <input type="text" class="form-control" id="no_plat" name="no_plat" value="{{ old('no_plat', '') }}" placeholder="Masukan No Plat">
                                @error('no_plat')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group supplier_pasir">
                                <label for="stnk">STNK</label>
                                <input type="file" class="form-control" id="stnk" name="stnk" value="{{ old('stnk', '') }}" placeholder="Masukan No Plat">
                                @error('stnk')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group supplier_pasir">
                                <label for="nik">NIK</label>
                                <input type="text" maxlength="16" minlength="16" class="form-control" id="nik" name="nik" value="{{ old('nik', '') }}" placeholder="Masukan NIK">
                                @error('nik')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- if role supplier  --}}
                            <div class="form-group supplier supplier_pasir">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" value="{{ old('alamat', '') }}" placeholder="Masukan Alamat"></textarea>
                                @error('alamat')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group supplier supplier_pasir">
                                <label for="no_hp">No Telp/No HP</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', '') }}" placeholder="Masukan No Telp/No HP">
                                @error('no_hp')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group supplier">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', '') }}" placeholder="Masukan Email">
                                @error('email')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group supplier">
                                <label for="web">Web</label>
                                <input type="web" class="form-control" id="web" name="web" value="{{ old('web', '') }}" placeholder="Masukan web">
                                @error('web')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    {{-- <th>Email</th> --}}
                    <th>Role</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php
                $no = 0;
                @endphp
                @foreach ($users as $item)
                <tr>
                    <td>{{ ++$no }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->username }}</td>
                    {{-- <td>{{ $item->email }}</td> --}}
                    <td>{{ $item->role }}</td>
                    <td>
                        <button class="btn btn-xs bg-orange btn-flat btn-ubah" data-toggle="modal" data-target="#modal-{{ $item->id }}">UBAH</button>
                        <button class="btn btn-xs bg-primary btn-flat" data-toggle="modal" data-target="#modal-{{ $item->id }}-detail">DETAIL</button>
                        <form action="{{ route('master.user.delete', $item->id) }}" method="post" style="display: inline">
                            @csrf
                            @method('delete')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus pengguna?')" class="btn btn-xs bg-maroon btn-flat">HAPUS</butt>
                        </form>
                    </td>
                    <div class="modal fade" id="modal-{{ $item->id }}-detail">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Detail Pengguna</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $item->name) }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $item->username) }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <input type="role" class="form-control" value="{{ old('role', $item->role) }}" disabled>
                                    </div>
                                    @if( $item->role == "supplier" )
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea class="form-control" disabled>{{ $item->alamat }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>No Telp/No HP</label>
                                        <input type="text" class="form-control" value="{{ $item->no_hp }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" value="{{ $item->email }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>Web</label>
                                        <input type="text" class="form-control" value="{{ $item->web }}" disabled>
                                    </div>
                                    @elseif( $item->role == "supplier_pasir" )
                                    <div class="form-group">
                                        <label>No Plat</label>
                                        <input type="text" class="form-control" value="{{ $item->no_plat }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>STNK</label>
                                        <a href="{{ asset('stnk') . '/' . $item->stnk }}" class="form-control" target="_blank">File STNK</a>
                                    </div>
                                    <div class="form-group">
                                        <label>NIK</label>
                                        <input type="text" class="form-control" value="{{ $item->nik }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea class="form-control" disabled>{{ $item->alamat }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>No Telp/No HP</label>
                                        <input type="text" class="form-control" value="{{ $item->no_hp }}" disabled>
                                    </div>

                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Keluar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade modal-ubah" id="modal-{{ $item->id }}">
                        <div class="modal-dialog">
                            <form action="{{ route('master.user.put', $item->id) }}" method="POST">
                                <div class="modal-content">
                                    @csrf
                                    @method('put')
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Ubah Pengguna</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name">Nama</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $item->name) }}" required placeholder="Masukan Nama">
                                            @error('name')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $item->username) }}" required placeholder="Masukan Username">
                                            @error('username')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" value="{{ old('password', '') }}" placeholder="Masukan Password">
                                            @error('password')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select class="form-control role_ubah" name="role">
                                                {{-- <option {{ $item->role == 'developer' ? 'selected' : '' }} value="developer">Developer</option> --}}
                                                {{-- <option {{ $item->role == 'superadmin' ? 'selected' : '' }} value="superadmin">Superadmin</option> --}}
                                                <option {{ $item->role == 'admin' ? 'selected' : '' }} value="admin">Admin</option>
                                                <option {{ $item->role == 'stockpile' ? 'selected' : '' }} value="stockpile">Stockpile</option>
                                                <option {{ $item->role == 'stockpile_pasir' ? 'selected' : '' }} value="stockpile_pasir">Stockpile Pasir</option>
                                                <option {{ $item->role == 'supplier' ? 'selected' : '' }} value="supplier">Supplier</option>
                                                <option {{ $item->role == 'supplier_pasir' ? 'selected' : '' }} value="supplier_pasir">Supplier Pasir</option>
                                                <option {{ $item->role == 'produksi' ? 'selected' : '' }} value="produksi">Produksi</option>
                                                <option {{ $item->role == 'manager' ? 'selected' : '' }} value="manager">Manager</option>
                                            </select>
                                        </div>
                                        {{-- if role supplier pasir --}}
                                        {{-- @if($item->role == 'supplier_pasir') --}}
                                        <div class="form-group supplier_pasir_ubah">
                                            <label for="no_plat">Nomor Plat</label>
                                            <input type="text" class="form-control" id="no_plat" name="no_plat" value="{{ old('no_plat', $item->no_plat) }}" placeholder="Masukan No Plat">
                                            @error('no_plat')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group supplier_pasir_ubah">
                                            <label for="stnk">STNK</label>
                                            <input type="file" class="form-control" id="stnk" name="stnk" value="{{ old('stnk', $item->stnk) }}" placeholder="Masukan No Plat">
                                            @error('stnk')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group supplier_pasir_ubah">
                                            <label for="nik">NIK</label>
                                            <input type="text" maxlength="16" minlength="16" class="form-control" id="nik" name="nik" value="{{ old('nik', $item->nik) }}" placeholder="Masukan NIK">
                                            @error('nik')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- @endif --}}
                                        {{-- if role supplier  --}}
                                        {{-- @if($item->role == 'supplier' || $item->role == 'supplier_pasir') --}}
                                        <div class="form-group supplier_ubah supplier_pasir_ubah">
                                            <label for="alamat">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" value="{{ old('alamat', '') }}" placeholder="Masukan Alamat">{{ $item->alamat }}</textarea>
                                            @error('alamat')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group supplier_ubah supplier_pasir_ubah">
                                            <label for="no_hp">No Telp/No HP</label>
                                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', $item->no_hp) }}" placeholder="Masukan No Telp/No HP">
                                            @error('no_hp')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- @endif
                                        @if($item->role == 'supplier') --}}
                                        <div class="form-group supplier_ubah">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $item->email) }}" placeholder="Masukan Email">
                                            @error('email')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group supplier_ubah">
                                            <label for="web">Web</label>
                                            <input type="web" class="form-control" id="web" name="web" value="{{ old('web', $item->web) }}" placeholder="Masukan web">
                                            @error('web')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- @endif --}}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </tr>

    </div>
    @endforeach
    </tbody>
    </table>
    </div>
    </div>
</section>
@endsection


@section('script')
<script src="{{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(function() {
        $('#example1').DataTable()
        $('#example2').DataTable({
            'paging': true
            , 'lengthChange': false
            , 'searching': false
            , 'ordering': true
            , 'info': true
            , 'autoWidth': false
        })
    })

    var CtrlUser = function() {
        return {
            init: function() {
                let role_el = $("#role");

                $('.supplier').hide();
                $('.supplier_pasir').hide();

                $('.supplier_ubah').hide();
                $('.supplier_pasir_ubah').hide();

                role_el.on('change', function() {
                    if (role_el.val() == 'supplier') {
                        CtrlUser.onSupplier();
                    } else if (role_el.val() == 'supplier_pasir') {
                        CtrlUser.onSupplierPasir();
                    } else {
                        $('.supplier').hide();
                        $('.supplier_pasir').hide();
                        CtrlUser.onSupplierRequired(false);
                        CtrlUser.onSupplierPasirRequired(false);
                    }
                })

                $(".role_ubah").on('change', function() {
                    if ($(this).val() == 'supplier') {
                        CtrlUser.onSupplierUbah();
                    } else if ($(this).val() == 'supplier_pasir') {
                        CtrlUser.onSupplierPasirUbah();
                    } else {
                        $('.supplier_ubah').hide();
                        $('.supplier_pasir_ubah').hide();
                        CtrlUser.onSupplierUbahRequired(false);
                        CtrlUser.onSupplierPasirUbahRequired(false);
                    }
                });

                $('button.btn-ubah').click(function() {
                    // $(this).parent().parent().find('.role_ubah').trigger('change');
                })
                
                $('.modal-ubah').on('shown.bs.modal', function() {
                    $(this).find('.role_ubah').trigger('change')
                })
            }
            , onSupplier: function() {
                $('.supplier_pasir').hide();
                $('.supplier').show();
                CtrlUser.onSupplierPasirRequired(false);
                CtrlUser.onSupplierRequired(true);
            }
            , onSupplierUbah: function() {
                $('.supplier_pasir_ubah').hide();
                $('.supplier_ubah').show();
                CtrlUser.onSupplierPasirUbahRequired(false);
                CtrlUser.onSupplierUbahRequired(true);
            }
            , onSupplierPasir: function() {
                $('.supplier').hide();
                $('.supplier_pasir').show();
                CtrlUser.onSupplierRequired(false);
                CtrlUser.onSupplierPasirRequired(true);
            }
            , onSupplierPasirUbah: function() {
                $('.supplier_ubah').hide();
                $('.supplier_pasir_ubah').show();
                CtrlUser.onSupplierUbahRequired(false);
                CtrlUser.onSupplierPasirUbahRequired(true);
            }
            , onSupplierRequired: function(bool) {
                $("#alamat").prop('required', bool);
                $("#no_hp").prop('required', bool);
                $("#email").prop('required', bool);
                $("#web").prop('required', bool);
            }
            , onSupplierUbahRequired: function(bool) {
                $("#alamat").prop('required', bool);
                $("#no_hp").prop('required', bool);
                $("#email").prop('required', bool);
                $("#web").prop('required', bool);
            }
            , onSupplierPasirRequired: function(bool) {
                $("#nik").prop('required', bool);
                $("#stnk").prop('required', bool);
                $("#no_plat").prop('required', bool);
                $("#alamat").prop('required', bool);
                $("#no_hp").prop('required', bool);
            }
            , onSupplierPasirUbahRequired: function(bool) {
                $("#nik").prop('required', bool);
                $("#no_plat").prop('required', bool);
                $("#alamat").prop('required', bool);
                $("#no_hp").prop('required', bool);
            }
        , }
    }();

    CtrlUser.init();

</script>
@endsection
