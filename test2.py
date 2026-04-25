import sys
# Create using explicit byte construction
# Line 76 currently: @if(session('success'))  with TWO )
# We want:         @if(session('success'))  with ONE )

# Lets use hex to ensure correct
base = "            @if(session(\x27success\x27))".encode()
print("Base:", base)

# Actually, simpler - lets slice off one paren
# Current has TWO ))) at the end
current = "            @if(session('success'))\n".encode()
print("Current:", current)

# Remove one )
fixed = current[:-3] + b"\n"  
print("Fixed:", fixed)
print("Fixed ) count:", fixed.count(b")"))
