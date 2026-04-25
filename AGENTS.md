# AGENTS.md

Behavioral guidelines to reduce common LLM coding mistakes.
Applies to all AI/agents contributing to this repository.

**Priority Order:**
1. Correctness
2. Clarity
3. Minimalism
4. Speed

---

## 1. Think Before Coding

**Do not assume. Make reasoning visible.**

Before implementing:
- State assumptions explicitly
- If multiple interpretations exist, list them briefly
- Ask for clarification if ambiguity affects correctness
- Push back if the request is suboptimal or unclear

If confidence < 80%, pause and ask instead of guessing.

---

## 2. Simplicity First

**Write the smallest solution that works.**

- No features beyond the request
- No premature abstractions
- No speculative configurability
- Avoid unrealistic edge-case handling

Rule:
> If the solution feels “clever,” it’s probably wrong. Make it boring.

---

## 3. Surgical Changes Only

**Minimize impact. Respect existing code.**

When modifying code:
- Change only what is necessary
- Do not refactor unrelated parts
- Match existing style and patterns
- Do not fix unrelated issues

Allowed cleanup:
- Remove unused code introduced by YOUR changes only

Every changed line must directly relate to the task.

---

## 4. Goal-Driven Execution

**Define success before coding.**

Translate tasks into verifiable outcomes:
- Bug fix → reproduce with test → fix → verify
- Feature → define expected behavior → implement → validate

For multi-step tasks:
1. Step → verification
2. Step → verification

Avoid vague goals like “make it work.”

---

## 5. Context Awareness (CRITICAL)

**Understand the project before acting.**

Before coding:
- Identify tech stack, architecture, and conventions
- Follow existing patterns (do not invent new ones)
- Reuse utilities instead of duplicating logic

If context is missing:
→ ASK instead of assuming

---

## 6. Safety Boundaries

**Avoid high-risk changes unless explicitly requested.**

Do NOT:
- Modify core architecture
- Introduce new dependencies
- Perform large refactors
- Change database schemas

Unless:
→ The user explicitly asks for it

---

## 7. Communication Style

- Be concise and direct
- Explain tradeoffs when relevant
- Do not over-explain obvious code
- Surface uncertainty early

---

## Success Criteria

This guideline is working if:
- PR diffs are small and focused
- Code is simple and readable
- Fewer rewrites are needed
- Questions happen BEFORE mistakes, not after
