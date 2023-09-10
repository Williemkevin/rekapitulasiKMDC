<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="card-body">
                        <form method="POST" action="{{route('user.store')}}">
                            @csrf
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" id="nama" required value="{{ old('nama') }}">
    
                                <label>Sigkatan</label>
                                <input type="text" name="namaSingkatan" class="form-control" id="namaSingkatan" required value="{{ old('namaSingkatan') }}">
                        
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" id="email" required value="{{ old('email') }}">
                        
                                <label>Nomor Telepon</label>
                                <input type="number" name="nomorTelepon" class="form-control" id="nomorTelepon" required value="{{ old('nomorTelepon') }}">
                        
                                <label>username</label>
                                <input type="text" name="username" class="form-control" id="username" required value="{{ old('username') }}">
                        
                                <label>Daftar Sebagai</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="admin" value="admin" {{ old('role') === 'admin' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="admin">Admin</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="dokter" value="dokter" {{ old('role') === 'dokter' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dokter">Dokter</label>
                                </div>
                                
    
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
    
                                <label>Confirm Password</label>
                                <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" required>
                                @error('confirmPassword')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <a href="/login"class="btn btn-primary" style="margin-top: 20px;">Back</a>
                            <button type="submit" class="btn btn-success" style="margin-top: 20px;">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
