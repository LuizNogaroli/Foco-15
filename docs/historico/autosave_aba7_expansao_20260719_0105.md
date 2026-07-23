# Autosave expandido para Aba 7 (Manifestações)

**Data:** 2026-07-19 01:05

## Estado Anterior (Antes)

### public/js/autosave.js (linha 16)
```javascript
if (!PROCESSO_ID || !ABA || ABA == 7) return;
```

## Estado Novo (Depois)

### public/js/autosave.js (linha 16)
```javascript
if (!PROCESSO_ID || !ABA) return;
```

## Plano de Rollback

Reverter a linha 16 de:
```javascript
if (!PROCESSO_ID || !ABA) return;
```
Para:
```javascript
if (!PROCESSO_ID || !ABA || ABA == 7) return;
```
