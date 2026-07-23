with open('resources/views/processos/abas/aba1.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()

text = text.replace(r"?? \'\''", "?? ''")
text = text.replace(r"?? \'\'", "?? ''")
text = text.replace(r"\'", "'")

# And since these fields are from the portal, they should probably be readonly!
text = text.replace('name="processo_sei" class="mask-sei" maxlength="20" value="{{ $requerimento->nup_sei ?? \'\' }}" required placeholder="00000.000000/0000-00"', 'name="processo_sei" class="mask-sei" maxlength="20" value="{{ $requerimento->nup_sei ?? \'\' }}" readonly placeholder="00000.000000/0000-00"')

with open('resources/views/processos/abas/aba1.blade.php', 'w', encoding='utf-8') as f:
    f.write(text)
