<?php

namespace App\Imports;

use App\Models\User;
use App\Models\EquipeServidor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ServidoresImport implements ToModel, WithHeadingRow
{
    use Importable;

    private int $importados = 0;
    private int $erros = 0;
    private array $logErros = [];

    public function model(array $row)
    {
        $nome = trim($row['nome'] ?? '');
        $cpf = preg_replace('/\D/', '', $row['cpf'] ?? '');
        $cargo = trim($row['cargo'] ?? '');
        $email = trim($row['email_institucional'] ?? $row['email'] ?? '');
        $telefone = trim($row['telefone_de_contato'] ?? $row['telefone'] ?? '');
        $superintendencia = strtoupper(trim($row['superintendencia_uf'] ?? $row['uf'] ?? ''));

        if (empty($nome) || empty($cpf) || empty($email)) {
            $this->erros++;
            $this->logErros[] = "Linha com dados incompletos: nome='{$nome}', cpf='{$cpf}', email='{$email}'";
            return null;
        }

        if (strlen($cpf) !== 11) {
            $this->erros++;
            $this->logErros[] = "CPF inválido para '{$nome}': {$cpf}";
            return null;
        }

        $user = User::where('cpf', $cpf)->first();

        if ($user) {
            $user->update([
                'name' => $nome,
                'cargo' => $cargo,
                'telefone' => $telefone,
                'uf' => $superintendencia ?: $user->uf,
            ]);
        } else {
            $user = User::create([
                'name' => $nome,
                'email' => $email,
                'cpf' => $cpf,
                'cargo' => $cargo,
                'telefone' => $telefone,
                'uf' => $superintendencia,
                'password' => Hash::make('password'),
            ]);
        }

        $this->importados++;
        return $user;
    }

    public function getImportados(): int
    {
        return $this->importados;
    }

    public function getErros(): int
    {
        return $this->erros;
    }

    public function getLogErros(): array
    {
        return $this->logErros;
    }
}
