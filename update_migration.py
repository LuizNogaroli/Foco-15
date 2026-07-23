import os
import glob

# Find the newly created migration file
migration_files = glob.glob('database/migrations/*_create_requerimentos_table.php')
if not migration_files:
    print("Migration not found")
    exit(1)

file_path = migration_files[0]

with open(file_path, 'r', encoding='utf-8') as f:
    text = f.read()

new_schema = """
        Schema::create('requerimentos', function (Blueprint $table) {
            $table->string('numero_requerimento')->primary();
            $table->string('tipo_requerimento')->nullable();
            $table->string('data_hora_recebimento')->nullable();
            $table->string('nup_sei')->nullable();
            $table->string('cpf_cnpj_requerente')->nullable();
            $table->string('nome_requerente')->nullable();
            $table->string('contato_requerente')->nullable();
            $table->string('cpf_cnpj_representante')->nullable();
            $table->string('nome_representante')->nullable();
            $table->string('contato_representante')->nullable();
            $table->string('projeto_prioritario')->nullable();
            $table->string('prioridade_legal')->nullable();
            $table->json('documentos_anexados')->nullable(); // Para lista de PDFs do portal
            $table->timestamps();
        });
"""

import re
text = re.sub(r"Schema::create\('requerimentos', function \(Blueprint \$table\) \{.*?\}\);", new_schema.strip(), text, flags=re.DOTALL)

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(text)

print(f"Updated {file_path}")
