<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CarrinhoController;

Auth::routes();

// Página Inicial (Visitante)
Route::get('/', [HomeController::class, 'publicHome'])->name('public.home');

// Página Inicial do Usuário Autenticado
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Rotas de Autenticação
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Rotas de Autenticação
Route::middleware(['auth'])->group(function () {
    //Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');    
});

Route::middleware('auth')->group(function () {
    Route::get('/user/bibliotecaJogos', [App\Http\Controllers\BibliotecaJogosController::class, 'index'])->name('user.bibliotecaJogos');
});

Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('carrinho');
Route::post('/carrinho/adicionar/{id}', [CarrinhoController::class, 'adicionarAoCarrinho'])->name('carrinho.adicionar');
Route::get('/carrinho/remover/{id}', [CarrinhoController::class, 'removerDoCarrinho'])->name('remover-do-carrinho');
