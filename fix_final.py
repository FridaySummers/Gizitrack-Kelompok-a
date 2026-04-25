with open("resources/views/layouts/sidebar.blade.php", "r") as f:
    lines = f.readlines()

# Current line 76: "            @if(session('success'))\n"  - TWO )
# Fixed line 76:  "            @if(session('success'))\n"   - ONE )

# We can simply remove one ) by slicing [:-2] + "\n" means we remove one char and add newline back
# Current has 36 chars: @if(session('success'))\n
# Fixed should have 35 chars: @if(session('success'))\n

lines[75] = lines[75][:-2] + "\n"  
lines[84] = lines[84][:-2] + "\n"

with open("resources/views/layouts/sidebar.blade.php", "w") as f:
    f.writelines(lines)

print("Fixed!")
