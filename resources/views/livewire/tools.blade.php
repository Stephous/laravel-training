<div>
    <style>
        /* Style pour le formulaire */
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        button[type="submit"] {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        /* Style pour la table des outils */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th,
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <div>
        <h2>Créer un outil</h2>
        <form wire:submit.prevent="create">
            <div>
                <label for="name">Nom</label>
                <input type="text" wire:model="name" id="name" required>
            </div>
            <div>
                <label for="price">Prix</label>
                <input type="text" wire:model="price" id="price" required>
            </div>
            <div>
                <label for="description">Description</label>
                <input type="text" wire:model="description" id="description" required>
            </div>
            <button type="submit">Créer</button>
        </form>
        <h2>Liste des outils</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tools as $tool)
                <tr>
                    <td>{{$tool->name}}</td>
                    <td>{{$tool->price->toArray()['price']}}</td>
                    <td>{{$tool->description}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <h2>Search Tool</h2>
        <form wire:submit.prevent="search">
            <div>
                <label for="search">Search</label>
                <input type="text" wire:model="search" id="search">
            </div>
            <button type="submit">Search</button>
        </form>
        <h2>Sort Tool</h2>
        <form wire:submit.prevent="sort">
            <div>
                <label for="sort">Sort</label>
                <select wire:model="sort" id="sort">
                    <option value="name">Nom</option>
                    <option value="price">Prix</option>
                    <option value="description">Description</option>
                </select>
            </div>
            <button type="submit">Sort</button>
        </form>
    </div>
</div>
