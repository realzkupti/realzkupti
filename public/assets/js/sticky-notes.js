/**
 * TailAdmin - Sticky Notes
 * Drag-and-drop, resizable sticky notes with auto-save
 */

class StickyNotesManager {
    constructor(menuId, companyId = null) {
        this.menuId = menuId;
        this.companyId = companyId;
        this.notes = [];
        this.draggedNote = null;
        this.resizingNote = null;
        this.autoSaveTimeout = null;
        this.zIndexCounter = 1000;

        this.colors = ['yellow', 'blue', 'green', 'pink', 'purple', 'orange'];

        this.init();
    }

    async init() {
        await this.loadNotes();
        this.setupEventListeners();
    }

    async loadNotes() {
        try {
            const response = await fetch(`/api/sticky-notes?menu_id=${this.menuId}&company_id=${this.companyId || ''}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const result = await response.json();

            if (result.success) {
                this.notes = result.notes;
                this.renderAllNotes();
            }
        } catch (error) {
            console.error('Error loading sticky notes:', error);
        }
    }

    renderAllNotes() {
        // Clear existing notes
        document.querySelectorAll('.sticky-note').forEach(el => el.remove());

        this.notes.forEach(note => {
            this.renderNote(note);
        });
    }

    renderNote(note) {
        const existingNote = document.getElementById(`sticky-note-${note.id}`);
        if (existingNote) {
            existingNote.remove();
        }

        const noteEl = document.createElement('div');
        noteEl.id = `sticky-note-${note.id}`;
        noteEl.className = `sticky-note sticky-note-${note.color}`;
        noteEl.style.cssText = `
            position: fixed;
            left: ${note.position_x}px;
            top: ${note.position_y}px;
            width: ${note.width}px;
            height: ${note.height}px;
            z-index: ${note.z_index};
            background: ${this.getColorBackground(note.color)};
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            padding: 12px;
            cursor: move;
            user-select: none;
            resize: both;
            overflow: auto;
            min-width: 200px;
            min-height: 150px;
        `;

        noteEl.innerHTML = `
            <div class="sticky-note-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <div style="display: flex; gap: 4px;">
                    ${this.colors.map(color => `
                        <button class="color-btn" onclick="stickyNotes.changeColor(${note.id}, '${color}')"
                                style="width: 16px; height: 16px; border-radius: 50%; background: ${this.getColorBackground(color)}; border: 2px solid ${color === note.color ? '#000' : '#fff'}; cursor: pointer;"></button>
                    `).join('')}
                </div>
                <button onclick="stickyNotes.deleteNote(${note.id})" style="background: transparent; border: none; font-size: 18px; cursor: pointer; color: #666;">×</button>
            </div>
            <textarea class="sticky-note-content" data-note-id="${note.id}"
                      style="width: 100%; height: calc(100% - 40px); border: none; background: transparent; resize: none; outline: none; font-family: 'Inter', sans-serif; font-size: 14px;">${note.content || ''}</textarea>
        `;

        document.body.appendChild(noteEl);

        // Make draggable
        this.makeDraggable(noteEl, note);

        // Auto-save on content change
        const textarea = noteEl.querySelector('.sticky-note-content');
        textarea.addEventListener('input', () => {
            this.autoSave(note.id, { content: textarea.value });
        });

        // Bring to front on click
        noteEl.addEventListener('mousedown', () => {
            this.bringToFront(noteEl, note);
        });
    }

    makeDraggable(element, note) {
        let isDragging = false;
        let startX, startY, initialX, initialY;

        const header = element.querySelector('.sticky-note-header');

        header.addEventListener('mousedown', (e) => {
            if (e.target.tagName === 'BUTTON') return;

            isDragging = true;
            startX = e.clientX;
            startY = e.clientY;
            initialX = element.offsetLeft;
            initialY = element.offsetTop;

            this.draggedNote = note;

            e.preventDefault();
        });

        document.addEventListener('mousemove', (e) => {
            if (!isDragging || this.draggedNote !== note) return;

            const dx = e.clientX - startX;
            const dy = e.clientY - startY;

            element.style.left = (initialX + dx) + 'px';
            element.style.top = (initialY + dy) + 'px';
        });

        document.addEventListener('mouseup', () => {
            if (isDragging && this.draggedNote === note) {
                isDragging = false;
                this.autoSave(note.id, {
                    position_x: element.offsetLeft,
                    position_y: element.offsetTop
                });
                this.draggedNote = null;
            }
        });

        // Handle resize
        new ResizeObserver(() => {
            if (isDragging) return;
            this.autoSave(note.id, {
                width: element.offsetWidth,
                height: element.offsetHeight
            });
        }).observe(element);
    }

    bringToFront(element, note) {
        this.zIndexCounter++;
        element.style.zIndex = this.zIndexCounter;
        this.autoSave(note.id, { z_index: this.zIndexCounter });
    }

    getColorBackground(color) {
        const colors = {
            yellow: '#FEF3C7',
            blue: '#DBEAFE',
            green: '#D1FAE5',
            pink: '#FCE7F3',
            purple: '#EDE9FE',
            orange: '#FED7AA'
        };
        return colors[color] || colors.yellow;
    }

    async changeColor(noteId, color) {
        await this.updateNote(noteId, { color });
    }

    autoSave(noteId, data) {
        clearTimeout(this.autoSaveTimeout);
        this.autoSaveTimeout = setTimeout(() => {
            this.updateNote(noteId, data);
        }, 1000);
    }

    async updateNote(noteId, data) {
        try {
            const response = await fetch(`/api/sticky-notes/${noteId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                // Update local note data
                const note = this.notes.find(n => n.id === noteId);
                if (note) {
                    Object.assign(note, data);
                }
            }
        } catch (error) {
            console.error('Error updating sticky note:', error);
        }
    }

    async createNote(color = 'yellow') {
        const data = {
            menu_id: this.menuId,
            company_id: this.companyId,
            content: '',
            color: color,
            position_x: 100 + (this.notes.length * 20),
            position_y: 100 + (this.notes.length * 20),
            width: 300,
            height: 180
        };

        try {
            const response = await fetch('/api/sticky-notes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                this.notes.push(result.note);
                this.renderNote(result.note);
            }
        } catch (error) {
            console.error('Error creating sticky note:', error);
        }
    }

    async deleteNote(noteId) {
        if (!confirm('Delete this note?')) return;

        try {
            const response = await fetch(`/api/sticky-notes/${noteId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const result = await response.json();

            if (result.success) {
                this.notes = this.notes.filter(n => n.id !== noteId);
                document.getElementById(`sticky-note-${noteId}`)?.remove();
            }
        } catch (error) {
            console.error('Error deleting sticky note:', error);
        }
    }

    setupEventListeners() {
        // Add button to create notes (if doesn't exist)
        if (!document.getElementById('add-sticky-note-btn')) {
            const btn = document.createElement('button');
            btn.id = 'add-sticky-note-btn';
            btn.innerHTML = '+ Note';
            btn.style.cssText = 'position: fixed; bottom: 20px; right: 20px; z-index: 9999; background: #3C50E0; color: white; padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.2);';
            btn.onclick = () => this.createNote();
            document.body.appendChild(btn);
        }
    }
}

// Global instance
let stickyNotes;

// Initialize on page load (example: menuId = 1)
document.addEventListener('DOMContentLoaded', function() {
    const menuId = 1; // Get from page context
    const companyId = null; // Get from page context if needed

    stickyNotes = new StickyNotesManager(menuId, companyId);
});
