<?php

namespace App\Http\Livewire\Pegawai;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Models\User;

class Index extends Component
{
    // Gunakan ini agar menggunakan pagination milik livewire
    use WithPagination;

    // db property
    public $name, $nip, $address, $phone, $password, $sign, $password_confirmation, $karyawan_id, $jabatan, $email, $employeeId, $userId;

    public $paginate = 10, $search, $formVisible = false;
    public $confirmingPegawaiDeletion = false, $isModal = false, $editModal = false;

    // Untuk mengupdate 'search' yang ada di url
    protected $queryString = [
        'search' => ['except' => ''],
    ];

    // Membuat listener untuk emit yang dibuat di komponen lain
    protected $listeners = ['employeeAdded', 'closeForm', 'employeeEdited', 'destroy'];

    public function render()
    {
        return view('livewire.pegawai.index', [
            'employees' => $this->search
                ? Employee::where('nip', 'like', '%' . $this->search . '%')
                ->orWhere('name', 'like', '%' . $this->search . '%')
                ->orWhere('phone', 'like', '%' . $this->search . '%')->latest()
                ->paginate($this->paginate)
                : Employee::latest()->paginate($this->paginate),
            'roles' => Role::all()
        ]);
    }

    // Untuk menampilkan form tambah
    public function create()
    {
        // $this->formVisible = 'create';
        $this->resetCreateForm();
        $this->isModal = true;
    }

    private function resetCreateForm()
    {
        $this->nip = null;
        $this->name = '';
        $this->nip = '';
        $this->address = '';
        $this->email = '';
        $this->jabatan = '';
        $this->phone = '';
    }

    public function store()
    {
        // Validasi data
        $this->validate([
            'nip' => ['required', 'numeric', 'unique:employees,nip', 'digits_between:16,20'],
            'name' => ['required'],
            'address' => ['required'],
            'phone' => 'required|numeric|digits_between:10,13|unique:employees,phone,' . $this->nip . ',nip',
            'email' => 'required|email|unique:users,email,' . $this->nip . ',karyawan_id',
        ]);

        // if jabaran id = 1 & 2 then apply unique validation for jabatan
        if ($this->jabatan == 1 || $this->jabatan == 2) {
            $this->validate([
                'jabatan' => ['unique:employees,jabatan'],
            ]);
        }

        // insert value for validate password is secret
        $this->password = bcrypt('secret');

        $generatePassword = bcrypt('12345678');
        // Masukkan kedalam database
        Employee::create([
            'nip' => $this->nip,
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'password' => $this->password,
            'email' => $this->email,
            'jabatan' => $this->jabatan,
        ]);

        // Store to Users
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'karyawan_id' => $this->nip,
        ])->assignRole($this->jabatan);

        // User::updateOrCreate(['karyawan_id' => $this->nip], [
        //     'name' => $this->name,
        //     'email' => $this->email,
        //     'password' => $this->password,
        //     'karyawan_id' => $this->nip,
        // ])->assignRole($this->jabatan);


        $this->isModal = false;
        $this->resetCreateForm();

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Data berhasil ditambahkan',
            'text' => ''
        ]);
    }

    // Untuk menghapus data
    public function destroy(Employee $student)
    {
        $student->delete();

        $this->confirmingPegawaiDeletion = false;

        // Untuk memberi notifikasi
        session()->flash('message', 'Employee deleted successfully');
    }

    // Untuk menampilkan form edit
    public function edit(Employee $employee)
    {
        $this->editModal = true;

        $this->employeeId = $employee['nip'];
        $this->nip = $employee['nip'];
        $this->name = $employee['name'];
        $this->address = $employee['address'];
        $this->phone = $employee['phone'];
        $this->jabatan = $employee['jabatan'];
        $this->email = $employee['email'];
        // Untuk mengirim data student yang di klik ke komponen lain (komponen edit)
        $this->emit('employeeEdit', $employee);
    }

    public function update()
    {
        // Validasi
        $this->validate([
            'name' => ['required'],
            'address' => ['required'],
            'phone' => 'required|numeric|digits_between:10,13|unique:employees,phone,' . $this->nip . ',nip',
            'email' => 'required|email|unique:users,email,' . $this->nip . ',karyawan_id',
        ]);

        if ($this->jabatan == 1 || $this->jabatan == 2) {
            $this->validate([
                'jabatan' => 'required|numeric|unique:employees,jabatan,' . $this->employeeId . ',nip'
            ]);
        } else {
            $this->validate([
                'jabatan' => 'required|numeric'
            ]);
        }

        // Update ke database
        // $employee->update([
        //     'name' => $this->name,
        //     'address' => $this->address,
        //     'phone' => $this->phone,
        //     'email' => $this->email,
        //     'jabatan' => $this->jabatan,
        // ]);
        if ($this->nip) {
            $employee = Employee::find($this->nip);
            $employee->update([
                'name' => $this->name,
                'address' => $this->address,
                'phone' => $this->phone,
                'email' => $this->email,
                'jabatan' => $this->jabatan,
            ]);


            // update to Users
            $user = User::where('karyawan_id', $this->nip)->first();
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);

            $user->syncRoles($this->jabatan);

            $this->editModal = false;
            $this->resetCreateForm();

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Data berhasil diperbarui',
            ]);
        }
    }

    public function closeForm()
    {
        $this->editModal = false;
        $this->isModal = false;
        $this->resetCreateForm();
    }
}
