with open('resources/views/processos/show.blade.php', 'r', encoding='utf-8') as f:
    show = f.read()

menu_html = """
<header class="menu">
    <div class="buttons-flow-line"></div>
    <div class="buttons-container">
        <div class="button-wrapper">
            <a href="?aba=1" style="text-decoration: none;">
                <button class="circle-btn {{ request('aba', 1) == 1 ? 'active' : '' }}">1</button>
                <span class="legend">Indicação do Imóvel</span>
            </a>
        </div>
        <div class="button-wrapper">
            <a href="?aba=2" style="text-decoration: none;">
                <button class="circle-btn {{ request('aba') == 2 ? 'active' : '' }}">2</button>
                <span class="legend">Diagnóstico Preliminar</span>
            </a>
        </div>
        <div class="button-wrapper">
            <a href="?aba=3" style="text-decoration: none;">
                <button class="circle-btn {{ request('aba') == 3 ? 'active' : '' }}">3</button>
                <span class="legend">Análise de Viabilidade</span>
            </a>
        </div>
        <div class="button-wrapper">
            <a href="?aba=7" style="text-decoration: none;">
                <button class="circle-btn {{ request('aba') == 7 ? 'active' : '' }}">7</button>
                <span class="legend">Visão Painel</span>
            </a>
        </div>
    </div>
</header>
"""

# Replace the previous <header> I injected
import re
show = re.sub(r'<header class="menu".*?</header>', menu_html, show, flags=re.DOTALL)

with open('resources/views/processos/show.blade.php', 'w', encoding='utf-8') as f:
    f.write(show)
