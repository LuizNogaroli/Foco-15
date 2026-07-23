with open('resources/views/processos/show.blade.php', 'r', encoding='utf-8') as f:
    show = f.read()

# Replace the sidebar-left with a top menu
menu_html = """
<header class="menu" style="background-color: #1e3a5f; padding: 10px; margin-bottom: 20px;">
    <div class="buttons-container" style="display: flex; gap: 20px; justify-content: center; align-items: center; color: white;">
        <div class="button-wrapper" style="text-align: center;">
            <a href="?aba=1" style="color: white; text-decoration: none; font-weight: bold;">Indicação do Imóvel</a>
        </div>
        <div class="button-wrapper" style="text-align: center;">
            <a href="?aba=2" style="color: white; text-decoration: none; font-weight: bold;">Diagnóstico Preliminar</a>
        </div>
        <div class="button-wrapper" style="text-align: center;">
            <a href="?aba=3" style="color: white; text-decoration: none; font-weight: bold;">Análise de Viabilidade</a>
        </div>
        <div class="button-wrapper" style="text-align: center;">
            <a href="?aba=7" style="color: white; text-decoration: none; font-weight: bold;">Manifestações</a>
        </div>
    </div>
</header>
"""

# We need to inject this menu before grid-container or replace sidebar-left.
# Let's replace sidebar-left with nothing.
import re
show = re.sub(r'<!-- Sidebar esquerda \(Menu\) -->.*?</aside>', '', show, flags=re.DOTALL)

# Inject the menu before grid-container
show = show.replace('<div class="grid-container">', menu_html + '\n    <div class="grid-container" style="grid-template-columns: 1fr 300px;">')

with open('resources/views/processos/show.blade.php', 'w', encoding='utf-8') as f:
    f.write(show)
