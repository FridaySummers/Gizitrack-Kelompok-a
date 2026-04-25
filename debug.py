with open("resources/views/layouts/sidebar.blade.php", "r") as f:
    lines = f.readlines()
print("Current line 76:", repr(lines[75]))
print("Current line 85:", repr(lines[84]))
