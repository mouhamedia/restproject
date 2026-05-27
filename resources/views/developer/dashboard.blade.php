<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#0f172a">
        <title>Developer Dashboard - MonProjet Resto</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            :root {
                color-scheme: dark;
                --bg: #07111f;
                --panel: rgba(15, 23, 42, 0.78);
                --panel-strong: rgba(2, 6, 23, 0.88);
                --line: rgba(255, 255, 255, 0.10);
                --text: #f8fafc;
                --muted: #cbd5e1;
                --accent: #38bdf8;
                --accent-2: #f59e0b;
                --accent-3: #22c55e;
            }

            * { box-sizing: border-box; }
            body {
                margin: 0;
                min-height: 100vh;
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                color: var(--text);
                background:
                    radial-gradient(circle at top left, rgba(56, 189, 248, 0.18), transparent 24%),
                    radial-gradient(circle at 82% 18%, rgba(245, 158, 11, 0.16), transparent 22%),
                    radial-gradient(circle at bottom right, rgba(34, 197, 94, 0.12), transparent 24%),
                    linear-gradient(135deg, #020617 0%, #07111f 42%, #0f172a 100%);
            }

            .shell {
                position: relative;
                overflow: hidden;
                min-height: 100vh;
                padding: 28px 0 48px;
            }

            .grid-noise {
                position: absolute;
                inset: 0;
                background-image:
                    linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px);
                background-size: 46px 46px;
                mask-image: linear-gradient(to bottom, rgba(0,0,0,0.5), transparent 88%);
                pointer-events: none;
            }

            .wrap {
                width: min(1180px, calc(100% - 32px));
                margin: 0 auto;
                position: relative;
                z-index: 1;
            }

            .topbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 16px;
                margin-bottom: 28px;
            }

            .brand {
                display: inline-flex;
                align-items: center;
                gap: 12px;
                font-weight: 700;
                letter-spacing: 0.04em;
            }

            .mark {
                width: 42px;
                height: 42px;
                border-radius: 14px;
                display: grid;
                place-items: center;
                background: linear-gradient(135deg, var(--accent), var(--accent-2));
                color: #08111f;
                box-shadow: 0 16px 36px rgba(56, 189, 248, 0.22);
            }

            .chips {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            .chip,
            .button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-height: 42px;
                padding: 0 16px;
                border-radius: 999px;
                border: 1px solid var(--line);
                background: rgba(255,255,255,0.04);
                color: var(--text);
                text-decoration: none;
            }

            .chip {
                color: var(--muted);
            }

            .hero {
                display: grid;
                grid-template-columns: minmax(0, 1.15fr) minmax(320px, 0.85fr);
                gap: 22px;
                margin-bottom: 22px;
            }

            .panel {
                background: var(--panel);
                border: 1px solid var(--line);
                border-radius: 26px;
                backdrop-filter: blur(20px);
                box-shadow: 0 24px 70px rgba(0, 0, 0, 0.32);
            }

            .hero-main {
                padding: 30px;
            }

            .eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                padding: 8px 14px;
                border-radius: 999px;
                background: rgba(56, 189, 248, 0.10);
                border: 1px solid rgba(56, 189, 248, 0.18);
                color: #d7f3ff;
                font-size: 0.92rem;
            }

            .eyebrow-dot {
                width: 8px;
                height: 8px;
                border-radius: 999px;
                background: var(--accent-3);
                box-shadow: 0 0 0 6px rgba(34, 197, 94, 0.14);
            }

            h1 {
                margin: 18px 0 12px;
                font-size: clamp(2.5rem, 5vw, 4.8rem);
                line-height: 0.96;
                letter-spacing: -0.05em;
            }

            .lead {
                margin: 0;
                max-width: 62ch;
                color: var(--muted);
                line-height: 1.75;
            }

            .stats-grid {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 14px;
                margin-top: 24px;
            }

            .stat {
                padding: 16px;
                border-radius: 18px;
                background: rgba(255,255,255,0.04);
                border: 1px solid rgba(255,255,255,0.08);
            }

            .stat strong {
                display: block;
                font-size: 1.5rem;
                margin-bottom: 4px;
            }

            .stat span {
                color: var(--muted);
                font-size: 0.92rem;
            }

            .side {
                padding: 20px;
                display: grid;
                gap: 14px;
            }

            .side-card {
                padding: 18px;
                border-radius: 20px;
                background: var(--panel-strong);
                border: 1px solid rgba(255,255,255,0.08);
            }

            .side-title {
                display: flex;
                justify-content: space-between;
                gap: 12px;
                align-items: center;
                margin-bottom: 14px;
                font-weight: 700;
            }

            .list {
                display: grid;
                gap: 12px;
            }

            .list-item {
                padding: 14px;
                border-radius: 16px;
                background: rgba(255,255,255,0.04);
                border: 1px solid rgba(255,255,255,0.07);
            }

            .list-item strong {
                display: block;
                margin-bottom: 4px;
            }

            .list-item small,
            .list-item span {
                color: var(--muted);
            }

            .sections {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 22px;
            }

            .section {
                padding: 22px;
            }

            .section h2 {
                margin: 0 0 16px;
                font-size: 1.15rem;
            }

            .table {
                display: grid;
                gap: 10px;
            }

            .row {
                display: grid;
                grid-template-columns: minmax(0, 1.5fr) repeat(2, minmax(90px, auto));
                gap: 12px;
                align-items: center;
                padding: 12px 14px;
                border-radius: 16px;
                background: rgba(255,255,255,0.04);
                border: 1px solid rgba(255,255,255,0.07);
            }

            .row small {
                color: var(--muted);
                display: block;
            }

            .pill {
                justify-self: start;
                padding: 6px 10px;
                border-radius: 999px;
                font-size: 0.85rem;
                background: rgba(245, 158, 11, 0.14);
                border: 1px solid rgba(245, 158, 11, 0.22);
                color: #ffe8b0;
            }

            .pill.green {
                background: rgba(34, 197, 94, 0.14);
                border-color: rgba(34, 197, 94, 0.22);
                color: #bbf7d0;
            }

            .footnote {
                margin-top: 18px;
                color: var(--muted);
                font-size: 0.95rem;
                line-height: 1.6;
            }

            @media (max-width: 980px) {
                .hero,
                .sections,
                .stats-grid {
                    grid-template-columns: 1fr 1fr;
                }

                .row {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 640px) {
                .topbar,
                .hero,
                .sections,
                .stats-grid {
                    grid-template-columns: 1fr;
                }

                .topbar {
                    flex-direction: column;
                    align-items: flex-start;
                }
            }
        </style>
    </head>
    <body>
        <div class="shell">
            <div class="grid-noise"></div>
            <div class="wrap">
                <header class="topbar">
                    <div class="brand">
                        <div class="mark">D</div>
                        <div>
                            MonProjet Resto<br>
                            <span style="color: var(--muted); font-weight: 400;">Developer dashboard</span>
                        </div>
                    </div>

                    <div class="chips">
                        <span class="chip">Accès interne</span>
                        <span class="chip">Rôle développeur</span>
                        <a class="button" href="{{ url('/') }}">Retour accueil</a>
                    </div>
                </header>

                <main>
                    <section class="hero">
                        <div class="panel hero-main">
                            <div class="eyebrow"><span class="eyebrow-dot"></span>Vue réservée aux développeurs</div>
                            <h1>Statistiques produit et signaux d’exploitation.</h1>
                            <p class="lead">
                                Cette zone centralise les métriques utiles au suivi technique et métier: activité globale,
                                volume d’abonnements, commandes récentes et éléments opérationnels invisibles pour les clients.
                            </p>

                            <div class="stats-grid">
                                <div class="stat"><strong>{{ $stats['users'] }}</strong><span>Utilisateurs</span></div>
                                <div class="stat"><strong>{{ $stats['restaurants'] }}</strong><span>Restaurants</span></div>
                                <div class="stat"><strong>{{ $stats['subscriptions'] }}</strong><span>Abonnements</span></div>
                                <div class="stat"><strong>{{ $stats['orders'] }}</strong><span>Commandes</span></div>
                                <div class="stat"><strong>{{ $stats['active_restaurants'] }}</strong><span>Restaurants actifs</span></div>
                                <div class="stat"><strong>{{ $stats['active_subscriptions'] }}</strong><span>Abonnements actifs</span></div>
                                <div class="stat"><strong>{{ $stats['menus_today'] }}</strong><span>Menus du jour</span></div>
                                <div class="stat"><strong>{{ $stats['pending_orders'] }}</strong><span>Commandes en attente</span></div>
                            </div>
                        </div>

                        <aside class="panel side">
                            <div class="side-card">
                                <div class="side-title">
                                    <span>Actions internes</span>
                                    <span class="pill green">Privé</span>
                                </div>
                                <div class="list">
                                    <div class="list-item">
                                        <strong>Suivre la charge</strong>
                                        <span>Repérer les pics de commandes et les menus publiés aujourd’hui.</span>
                                    </div>
                                    <div class="list-item">
                                        <strong>Vérifier l’état métier</strong>
                                        <span>Contrôler les restaurants actifs et les abonnements encore valides.</span>
                                    </div>
                                    <div class="list-item">
                                        <strong>Accéder aux données techniques</strong>
                                        <span>Créer plus tard des vues d’audit, d’erreurs ou de logs internes.</span>
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </section>

                    <section class="sections">
                        <div class="panel section">
                            <h2>Restaurants récents</h2>
                            <div class="table">
                                @forelse ($recentRestaurants as $restaurant)
                                    <div class="row">
                                        <div>
                                            <strong>{{ $restaurant->name }}</strong>
                                            <small>{{ $restaurant->owner?->name }} · {{ $restaurant->owner?->email }}</small>
                                        </div>
                                        <span class="pill {{ $restaurant->is_active ? 'green' : '' }}">
                                            {{ $restaurant->is_active ? 'Actif' : 'Inactif' }}
                                        </span>
                                        <span>{{ $restaurant->created_at?->format('d/m/Y') }}</span>
                                    </div>
                                @empty
                                    <div class="row">
                                        <div>
                                            <strong>Aucun restaurant</strong>
                                            <small>Les données apparaîtront ici après les premiers enregistrements.</small>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="panel section">
                            <h2>Commandes récentes</h2>
                            <div class="table">
                                @forelse ($recentOrders as $order)
                                    <div class="row">
                                        <div>
                                            <strong>{{ $order->restaurant?->name }}</strong>
                                            <small>
                                                {{ $order->user?->name }} · {{ $order->dailyMenu?->title }}
                                                @if ($order->dailyMenu?->menu_date)
                                                    · {{ \Illuminate\Support\Carbon::parse($order->dailyMenu->menu_date)->format('d/m/Y') }}
                                                @endif
                                            </small>
                                        </div>
                                        <span class="pill {{ $order->status === 'delivered' ? 'green' : '' }}">{{ ucfirst($order->status) }}</span>
                                        <span>{{ number_format((float) $order->total_price, 0, ',', ' ') }}</span>
                                    </div>
                                @empty
                                    <div class="row">
                                        <div>
                                            <strong>Aucune commande</strong>
                                            <small>Les dernières commandes s’afficheront ici.</small>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </section>

                    <p class="footnote">
                        Cette page est protégée par le middleware de rôle et n’est accessible qu’aux comptes marqués comme développeur.
                    </p>
                </main>
            </div>
        </div>
    </body>
</html>
