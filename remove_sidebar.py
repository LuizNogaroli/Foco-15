with open('resources/views/processos/show.blade.php', 'r', encoding='utf-8') as f:
    show = f.read()

import re

# Remove the flex container and sidebar-right
# The structure is currently:
# <div style="display: flex; gap: 20px;">
#     <div class="main-content" style="flex: 1;">
#         ...
#     </div>
#     <aside class="sidebar-right" ...> ... </aside>
# </div>

show = re.sub(r'<div style="display: flex; gap: 20px;">\s*<div class="main-content" style="flex: 1;">', '<div class="main-content">', show, flags=re.DOTALL)
show = re.sub(r'\s*</div>\s*<aside class="sidebar-right".*?</aside>\s*</div>', '\n    </div>', show, flags=re.DOTALL)

with open('resources/views/processos/show.blade.php', 'w', encoding='utf-8') as f:
    f.write(show)
