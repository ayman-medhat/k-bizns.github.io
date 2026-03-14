# Data Flow

This page describes how data moves through the app at a high level (who talks to what, and what gets stored).

## Level 0 (Context)

```mermaid
flowchart LR
  U[Employee / Manager] -->|Browser HTTP| APP((k-bizns Laravel App))
  SA[Super Admin] -->|Browser HTTP| APP

  APP --> AUTH[Auth (login/logout)\nRBAC (roles/permissions)]
  APP --> TEN[Tenant + Ownership\n(TenantMiddleware, TenantScope,\nHierarchicalScope)]
  APP --> SUB[Subscription + Limits\n(FeatureGate, EnforceLimit)]
  APP --> CRM[CRM Modules\nClients, Contacts, Deals\nKanban updates]

  AUTH --> DB[(Database)]
  TEN --> DB
  SUB --> DB
  CRM --> DB

  CRM --> FS[(File Storage\npublic disk uploads)]
```

## Level 1 (Core Processes and Stores)

```mermaid
flowchart TB
  subgraph External
    U[Employee / Manager]
    SA[Super Admin]
  end

  subgraph App["Laravel Application"]
    MW[Web Middleware Stack\n(SetTheme, SetLocale, TenantMiddleware)]
    POL[Policies\n(authorizeResource)]
    SC[Model Scopes\n(TenantScope, HierarchicalScope)]

    P1[Company Admin\nUsers, Settings]
    P2[CRM CRUD\nClients/Contacts/Deals]
    P3[Activity Tracking\n(morph: subject)]
    P4[Super Admin\nCompanies, Plans, Subscriptions]
  end

  subgraph Stores
    S1[(companies)]
    S2[(users + roles/permissions)]
    S3[(subscription_plans)]
    S4[(company_subscriptions)]
    S5[(clients)]
    S6[(contacts)]
    S7[(deals)]
    S8[(activities)]
    S9[(addresses + reference data)]
    FS[(public storage)]
  end

  U --> MW
  SA --> MW

  MW --> POL
  POL --> P1
  POL --> P2
  POL --> P3
  POL --> P4

  P1 --> SC
  P2 --> SC
  P3 --> SC
  P4 --> SC

  SC --> S1
  SC --> S2
  SC --> S3
  SC --> S4
  SC --> S5
  SC --> S6
  SC --> S7
  SC --> S8
  SC --> S9

  P2 --> FS
```

## Notes (What Controls Visibility)

- Tenant isolation: most business models include `company_id` and use `TenantScope` (set via `TenantMiddleware` session).
- Ownership visibility: many models use `HierarchicalScope` (current user plus subordinates, unless admin roles).
- Permissions: controllers use `authorizeResource(...)` and policies depend on Spatie roles/permissions.

