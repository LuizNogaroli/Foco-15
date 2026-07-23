with open('app/Models/Requerimento.php', 'r', encoding='utf-8') as f:
    text = f.read()

new_model = """
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requerimento extends Model
{
    use HasFactory;

    protected $table = 'requerimentos';
    
    protected $primaryKey = 'numero_requerimento';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'numero_requerimento',
        'tipo_requerimento',
        'data_hora_recebimento',
        'nup_sei',
        'cpf_cnpj_requerente',
        'nome_requerente',
        'contato_requerente',
        'cpf_cnpj_representante',
        'nome_representante',
        'contato_representante',
        'projeto_prioritario',
        'prioridade_legal',
        'documentos_anexados',
    ];

    protected $casts = [
        'documentos_anexados' => 'array',
    ];
}
"""

import re
text = re.sub(r'namespace App\\Models;.*?\}', new_model.strip(), text, flags=re.DOTALL)

with open('app/Models/Requerimento.php', 'w', encoding='utf-8') as f:
    f.write(text)
