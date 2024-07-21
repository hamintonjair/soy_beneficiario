<?php

namespace App\Controllers;

use App\Models\BeneficiaryModel;
use App\Models\ComentarioModel;


class Beneficiary extends BaseController
{
    protected $beneficiario, $comentarios;

    public function __construct()
    {
        $this->beneficiario = new BeneficiaryModel();
        $this->comentarios = new ComentarioModel();
    }

    public function index()
    {
        $data['comentarios'] = $this->comentarios->first();
        return view('sitio/search', $data);
  
    }

    public function search()
    {

        $cedula = $this->request->getPost('cedula');

        $data['beneficiary'] = $this->beneficiario->where('cedula', $cedula)->first();
        if ($data['beneficiary']) {
            if ($data['beneficiary']['estado'] == 'Beneficiario') {
                $data['message'] = "La persona con cédula $cedula es beneficiario/a.";
            } else {
                $data['message'] = "La persona $cedula no es beneficiario/a.";
            }
        } else {
            $data['message'] = "La persona $cedula no esta en la base de datos.";
        }

        $data['comentarios'] = $this->comentarios->first();
        return view('sitio/search', $data);
    }

    public function admin()
    {
        // Verificar si el usuario está autenticado
        $session = session();
        if (!$session->get('logged_in')) {
            echo '<script>window.location.href="http://localhost/soy_beneficiario/login"</script>';
            return;
        }

        // Obtener el término de búsqueda si se envió
        $search = $this->request->getGet('search');

        if ($search) {
            $this->beneficiario->like('nombre', $search)
                ->orLike('apellidos', $search)
                ->orLike('cedula', $search)
                ->orLike('ciudad', $search)
                ->orLike('estado', $search);
        }

        $page = $this->request->getGet('page') ?? 1; // Página actual
        $perPage = 10; // Número de registros por página
        $this->beneficiario->orderBy('id', 'DESC');
        // Obtén el total de registros
        $total = $this->beneficiario->countAllResults(false);
        $totalPages = ceil($total / $perPage); // Calcula el total de páginas

        $data['beneficiaries'] = $this->beneficiario->paginate($perPage, 'default', $page);
        $data['pager'] = $this->beneficiario->pager; // Para la navegación de la paginación
        $data['totalPages'] = $totalPages; // Pasa el total de páginas a la vista
        $data['search'] = $search; // Pasar el término de búsqueda a la vista

        return view('admin/administracion', $data);
    }
    public function create()
    {
        return view('create');
    }

    public function store()
    {
        $cedula = $this->request->getPost('cedula');

        // Verificar si la cédula ya existe en la base de datos
        $existingBeneficiary = $this->beneficiario->where('cedula', $cedula)->first();

        if ($existingBeneficiary) {
            // Si ya existe un beneficiario con esa cédula, enviar un mensaje de error
            $message = "Ya existe un beneficiario con la cédula $cedula. No se puede agregar duplicados.";
            return redirect()->to('admin')->with('error', $message);
        } else {
            // Si no existe, proceder a insertar los datos
            $data = [
                'nombre' => $this->request->getPost('nombre'),
                'apellidos' => $this->request->getPost('apellidos'),
                'cedula' => $cedula,
                'ciudad' => $this->request->getPost('ciudad'),
                'estado' => $this->request->getPost('estado'),

            ];

            $this->beneficiario->insert($data);

            // Enviar mensaje de éxito
            $message = "Beneficiario agregado correctamente con la cédula $cedula.";
            return redirect()->to('admin')->with('success', $message);
        }
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'apellidos' => $this->request->getPost('apellidos'),
            'cedula' => $this->request->getPost('cedula'),
            'ciudad' => $this->request->getPost('ciudad'),
            'estado' => $this->request->getPost('estado'),
        ];
        $updateSuccess = $this->beneficiario->update($id, $data);

        if ($updateSuccess) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Beneficiario actualizado correctamente.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No se pudo actualizar el beneficiario. Intente nuevamente.'
            ]);
        }
    }


    public function edit($id)
    {
        $beneficiary = $this->beneficiario->find($id);
        echo json_encode($beneficiary);
    }
    public function delete($id)
    {

        $result = $this->beneficiario->delete($id);
        if ($result) {
            return $this->response->setJSON(['ok' => true, 'message' => 'Beneficiario eliminado correctamente.']);
        } else {
            return $this->response->setJSON(['ok' => false, 'message' => 'No se pudo eliminar el beneficiario.']);
        }
    }
    public function iniciar_sesion()
    {
        // Muestra la vista de login
        return view('admin/login');
    }
    public function login()
    {
        // Validación de formulario
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('admin/login', ['validation' => $validation]);
        }

        // Obtener datos del formulario
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Verificar las credenciales (esto es un ejemplo básico, deberías validar y autenticar correctamente)
        if ($username === 'admin' && $password === 'admin123') {
            // Iniciar sesión (esto es un ejemplo básico, deberías implementar tu lógica de autenticación real)
            $session = session();
            $session->set(['username' => $username, 'logged_in' => true]);

            // Redirigir al área de administrador
            return redirect()->to('admin'); // Cambia 'admin/dashboard' por tu ruta real del área de administrador
        } else {
            // Credenciales incorrectas, mostrar mensaje de error
            $data['error'] = 'Nombre de usuario o contraseña incorrectos.';
            return view('admin/login', $data);
        }
    }

    public function logout()
    {
        // Cerrar sesión y redirigir al inicio de sesión
        $session = session();
        $session->destroy();
        echo '<script>window.location.href="http://localhost/soy_beneficiario/login"</script>';
    }
    public function setComentarios(){
        // Esta función muestra los comentarios de los beneficiarios en la vista public/comentarios
        $data['comentarios'] = $this->comentarios->first();
        return view('admin/comentario', $data);
    }
    public function actualizar()
    {
        $id = $this->request->getPost('idempresa');
        $titulo = $this->request->getPost('titulo');
        $comentario = $this->request->getPost('comentario');

        $data = [
            'titulo' => $titulo,
            'mensaje' => $comentario,
        ];

        // Validar los datos antes de actualizar
        if ($this->validate([
            'titulo' => 'required|min_length[3]',
            'comentario' => 'required|min_length[3]',
        ])) {
            // Actualizar el comentario en la base de datos
            if ($this->comentarios->update($id, $data)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Comentario actualizado exitosamente.']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'No se pudo actualizar el comentario. Inténtalo de nuevo.']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Datos inválidos.', 'errors' => $this->validator->getErrors()]);
        }
    }
}
