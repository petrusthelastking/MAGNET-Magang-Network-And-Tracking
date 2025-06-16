import xml.etree.ElementTree as ET
import networkx as nx
import matplotlib.pyplot as plt
from pathlib import Path
from urllib.parse import urlparse


SCRIPTS_DIR = Path(__file__).parent
PROJECT_DIR = SCRIPTS_DIR.parent

tree = ET.parse(PROJECT_DIR / 'public' / 'sitemap.xml')
root = tree.getroot()
ns = {'ns': 'http://www.sitemaps.org/schemas/sitemap/0.9'}

# Build graph
G = nx.DiGraph()
root_domain = "/"
G.add_node(root_domain)

max_depth = 1
node_count = 0

for url in root.findall('ns:url', ns):
    loc_elem = url.find('ns:loc', ns)
    if loc_elem is not None:
        full_url = loc_elem.text.strip()
        parsed_url = urlparse(full_url)
        path_parts = parsed_url.path.strip('/').split('/')
        node_count += 1
        max_depth = max(max_depth, len(path_parts))
        parent = root_domain
        for i in range(1, len(path_parts)):
            child = '/'.join(path_parts[:i+1])
            G.add_edge(parent, child)
            parent = child

# Tree layout positioning (top-down)
def hierarchy_pos(G, root, width=1., vert_gap=0.3, vert_loc=0, xcenter=0.5, pos=None, parent=None):
    """
    Recursively positions nodes in a tree layout.
    """
    if pos is None:
        pos = {root: (xcenter, vert_loc)}
    else:
        pos[root] = (xcenter, vert_loc)

    children = list(G.neighbors(root))
    if len(children) != 0:
        dx = width / len(children)
        nextx = xcenter - width / 2 - dx / 2
        for child in children:
            nextx += dx
            pos = hierarchy_pos(G, child, width=dx, vert_gap=vert_gap,
                                vert_loc=vert_loc - vert_gap, xcenter=nextx, pos=pos, parent=root)
    return pos

# Dynamically adjust figure size based on content
fig_width = max(12, node_count * 1.5)
fig_height = max(8, max_depth * 2)

pos = hierarchy_pos(G, root_domain)

plt.figure(figsize=(fig_width, fig_height))
nx.draw(G, pos,
        with_labels=True,
        arrows=True,
        node_color='lightgreen',
        node_size=3000,
        font_size=10,
        font_weight='bold',
        verticalalignment='center')

plt.title("Sitemap Tree Structure", fontsize=16, pad=20)
plt.tight_layout()
plt.savefig(SCRIPTS_DIR / "sitemap_tree.png", dpi=300)
