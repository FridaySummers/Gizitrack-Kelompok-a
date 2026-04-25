with open("resources/views/layouts/sidebar.blade.php", "r") as f:
    lines = f.readlines()
lines[75] = "            @if(session('success'))\n"
lines[84] = "            @if(session('error'))\n"
with open("resources/views/layouts/sidebar.blade.php", "w") as f:
    f.writelines(lines)
print("Fixed!")
