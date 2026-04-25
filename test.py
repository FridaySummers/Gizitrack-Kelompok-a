current = "            @if(session('success'))\n"
fixed = "            @if(session('success'))\n"
print("Current bytes:", [ord(c) for c in current])
print("Fixed bytes:", [ord(c) for c in fixed])
print("Equal?", current == fixed)
