<template>
  <Teleport to="body">
    <div v-if="isMounted" class="rtv-sheet-root" role="dialog" aria-modal="true">
      <div class="rtv-sheet-backdrop" @click="handleBackdropClick"></div>
      <div
        ref="panel"
        class="rtv-sheet-panel"
        :class="panelClasses"
        :style="panelStyle"
        tabindex="-1"
        @keydown="handleKeydown"
      >
        <div class="rtv-sheet-handle" @pointerdown.stop.prevent="onPointerDown">
          <span class="rtv-sheet-grabber"></span>
        </div>
        <div class="rtv-sheet-content">
          <slot :close="requestClose" :expand="expand"></slot>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<script>
export default {
  name: 'BottomSheet',
  emits: ['update:modelValue', 'expanded-change', 'after-close'],
  props: {
    modelValue: {
      type: Boolean,
      default: false,
    },
    snapPoints: {
      type: Array,
      default: () => [0.5, 1],
    },
    initialSnap: {
      type: Number,
      default: 0,
    },
    lockBodyScroll: {
      type: Boolean,
      default: true,
    },
    closeThreshold: {
      type: Number,
      default: 0.25,
    },
    backdropClosesExpanded: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      isMounted: false,
      isVisible: false,
      isExpanded: false,
      isDragging: false,
      currentHeightPx: 0,
      snapPointsPx: [],
      dragStartY: 0,
      dragStartHeight: 0,
      lastPointerY: 0,
      lastPointerTs: 0,
      prevPointerY: 0,
      startSnapIndex: 0,
      rafId: null,
      ignoreBackdropUntil: 0,
      previousBodyOverflow: null,
      resizeHandler: null,
      keydownHandler: null,
      focusBeforeOpen: null,
    };
  },
  computed: {
    panelClasses() {
      return {
        'is-visible': this.isVisible,
        'is-expanded': this.isExpanded,
        'is-dragging': this.isDragging,
      };
    },
    panelStyle() {
      return {
        height: `${this.currentHeightPx}px`,
      };
    },
  },
  watch: {
    modelValue: {
      immediate: true,
      handler(val) {
        if (val) {
          this.open();
        } else {
          this.close();
        }
      },
    },
  },
  beforeUnmount() {
    this.removeGlobalListeners();
    this.unlockBodyScroll();
  },
  methods: {
    open() {
      if (this.isMounted) {
        this.isVisible = true;
        this.isExpanded = this.snapPoints.length > 1 && this.initialSnap === this.snapPoints.length - 1;
        return;
      }
      this.isMounted = true;
      this.$nextTick(() => {
        this.updateSnapPoints();
        const initialIndex = Math.min(Math.max(this.initialSnap, 0), this.snapPointsPx.length - 1);
        this.currentHeightPx = this.snapPointsPx[initialIndex] || Math.round(window.innerHeight * 0.5);
        this.isVisible = true;
        this.isExpanded = initialIndex === this.snapPointsPx.length - 1;
        this.focusBeforeOpen = document.activeElement;
        this.$nextTick(() => {
          const panel = this.$refs.panel;
          if (panel) panel.focus({ preventScroll: true });
        });
        this.addGlobalListeners();
        if (this.lockBodyScroll) this.lockBody();
      });
    },
    close() {
      if (!this.isMounted) return;
      this.isVisible = false;
      this.isExpanded = false;
      this.removeGlobalListeners();
      this.unlockBodyScroll();
      const panel = this.$refs.panel;
      if (panel) {
        const listener = () => {
          panel.removeEventListener('transitionend', listener);
          if (!this.isVisible) {
            this.isMounted = false;
            this.currentHeightPx = 0;
            if (this.focusBeforeOpen) {
              this.focusBeforeOpen.focus?.();
              this.focusBeforeOpen = null;
            }
            this.$emit('after-close');
          }
        };
        panel.addEventListener('transitionend', listener);
        // fallback in case transitionend doesn't fire
        setTimeout(listener, 260);
      } else {
        this.isMounted = false;
        this.$emit('after-close');
      }
    },
    requestClose() {
      this.$emit('update:modelValue', false);
    },
    expand() {
      this.snapToIndex(this.snapPointsPx.length - 1);
    },
    handleBackdropClick() {
      if (this.isDragging) return;
      if (Date.now() < this.ignoreBackdropUntil) return;
      if (this.isExpanded && !this.backdropClosesExpanded) return;
      this.requestClose();
    },
    handleKeydown(event) {
      if (event.key === 'Escape') {
        event.preventDefault();
        if (this.isExpanded && !this.backdropClosesExpanded) {
          // collapse to first snap instead of closing
          this.snapToIndex(0);
        } else {
          this.requestClose();
        }
      }
    },
    addGlobalListeners() {
      if (!this.resizeHandler) {
        this.resizeHandler = this.updateSnapPoints;
        window.addEventListener('resize', this.resizeHandler);
      }
    },
    removeGlobalListeners() {
      if (this.resizeHandler) {
        window.removeEventListener('resize', this.resizeHandler);
        this.resizeHandler = null;
      }
    },
    lockBody() {
      this.previousBodyOverflow = document.body.style.overflow;
      document.body.style.overflow = 'hidden';
    },
    unlockBodyScroll() {
      if (this.previousBodyOverflow !== null) {
        document.body.style.overflow = this.previousBodyOverflow;
        this.previousBodyOverflow = null;
      }
    },
    updateSnapPoints() {
      const vh = window.innerHeight || 0;
      const sanitized = this.snapPoints.length ? this.snapPoints : [0.5, 1];
      this.snapPointsPx = sanitized.map((ratio) => {
        const clamped = Math.min(Math.max(ratio, 0.25), 1);
        return Math.round(clamped * vh);
      }).sort((a, b) => a - b);
      // ensure unique values
      this.snapPointsPx = [...new Set(this.snapPointsPx)];
    },
    snapToIndex(index) {
      if (!this.snapPointsPx.length) this.updateSnapPoints();
      const clamped = Math.min(Math.max(index, 0), this.snapPointsPx.length - 1);
      this.currentHeightPx = this.snapPointsPx[clamped];
      this.isExpanded = clamped === this.snapPointsPx.length - 1;
      this.$emit('expanded-change', this.isExpanded);
    },
    onPointerDown(event) {
      if (!this.isMounted) return;
      const panel = this.$refs.panel;
      if (!panel) return;
      this.isDragging = true;
      panel.classList.add('is-dragging');
      this.dragStartY = event.clientY;
      this.dragStartHeight = this.currentHeightPx;
      this.lastPointerY = event.clientY;
      this.prevPointerY = event.clientY;
      this.lastPointerTs = performance.now();
      this.startSnapIndex = this.findNearestSnapIndex();
      event.currentTarget.setPointerCapture(event.pointerId);
      event.currentTarget.addEventListener('pointermove', this.onPointerMove, { passive: false });
      event.currentTarget.addEventListener('pointerup', this.onPointerUp, { passive: false, once: true });
      event.currentTarget.addEventListener('pointercancel', this.onPointerUp, { passive: false, once: true });
    },
    onPointerMove(event) {
      if (!this.isDragging) return;
      const now = performance.now();
      const dy = this.dragStartY - event.clientY;
      this.prevPointerY = this.lastPointerY;
      this.lastPointerY = event.clientY;
      this.lastPointerTs = now;
      if (this.rafId) return;
      this.rafId = requestAnimationFrame(() => {
        this.rafId = null;
        const viewport = window.innerHeight;
        const minHeight = Math.min(...this.snapPointsPx);
        const maxHeight = Math.max(...this.snapPointsPx);
        let target = this.dragStartHeight + dy;
        if (Number.isFinite(minHeight)) target = Math.max(target, minHeight * 0.6);
        if (Number.isFinite(maxHeight)) target = Math.min(target, maxHeight);
        this.currentHeightPx = target;
      });
      event.preventDefault();
    },
    onPointerUp(event) {
      if (!this.isDragging) return;
      this.isDragging = false;
      const panel = this.$refs.panel;
      if (panel) panel.classList.remove('is-dragging');
      if (this.rafId) {
        cancelAnimationFrame(this.rafId);
        this.rafId = null;
      }

      const vh = window.innerHeight;
      const heightRatio = this.currentHeightPx / vh;
      const dt = Math.max(1, performance.now() - this.lastPointerTs);
      const velocity = (event.clientY - this.prevPointerY) / dt; // px per ms (positive = down)
      const fastSwipe = Math.abs(velocity) > 0.32;
      const upwardDrag = this.dragStartY - event.clientY;
      const downwardDrag = event.clientY - this.dragStartY;
      const totalSnaps = this.snapPointsPx.length;
      const startedAtFirst = this.startSnapIndex === 0;
      const startedAtLast = this.startSnapIndex === totalSnaps - 1;
      const expandBoundary = Math.min(0.55, (this.snapPoints[this.snapPoints.length - 1] || 1) - 0.015);
      const closeDragThreshold = startedAtFirst ? 10 : 18;
      const expandDragThreshold = startedAtLast ? 14 : 18;

      // Determine target snap
      let targetIndex = this.findNearestSnapIndex();

      if (fastSwipe) {
        if (velocity < 0) {
          // swipe up -> expand
          targetIndex = this.snapPointsPx.length - 1;
        } else {
          // swipe down -> collapse/close
          if (startedAtFirst || heightRatio <= this.closeThreshold) {
            this.ignoreBackdropUntil = Date.now() + 300;
            this.requestClose();
            return;
          }
          targetIndex = Math.max(0, this.snapPointsPx.length - 2);
        }
      } else {
        const firstSnapRatio = totalSnaps ? this.snapPointsPx[0] / vh : 0.5;
        if (startedAtFirst && (downwardDrag > closeDragThreshold || heightRatio <= firstSnapRatio - 0.08 || heightRatio <= this.closeThreshold)) {
          this.ignoreBackdropUntil = Date.now() + 300;
          this.requestClose();
          return;
        }
        if (startedAtLast && downwardDrag > expandDragThreshold) {
          targetIndex = Math.max(0, totalSnaps - 2);
        } else if (upwardDrag > expandDragThreshold || heightRatio >= expandBoundary) {
          targetIndex = this.snapPointsPx.length - 1;
        } else {
          targetIndex = Math.max(0, this.startSnapIndex);
        }
      }

      this.snapToIndex(targetIndex);
      this.ignoreBackdropUntil = Date.now() + 200;
    },
    findNearestSnapIndex() {
      if (!this.snapPointsPx.length) return 0;
      const diffs = this.snapPointsPx.map((value) => Math.abs(value - this.currentHeightPx));
      let index = 0;
      let min = diffs[0];
      diffs.forEach((diff, idx) => {
        if (diff < min) {
          min = diff;
          index = idx;
        }
      });
      return index;
    },
  },
};
</script>

<style scoped>
.rtv-sheet-root {
  position: fixed;
  inset: 0;
  z-index: 1048;
  display: flex;
  justify-content: flex-end;
  align-items: flex-end;
}

.rtv-sheet-backdrop {
  position: absolute;
  inset: 0;
  background: rgba(15, 23, 42, 0.45);
  backdrop-filter: blur(2px);
  opacity: 0;
  animation: rtv-sheet-fade-in 180ms ease forwards;
}

.rtv-sheet-panel {
  position: relative;
  border-top-left-radius: 18px;
  border-top-right-radius: 18px;
  background: #fff;
  width: 100%;
  max-width: 640px;
  margin: 0 auto;
  transform: translateY(100%);
  transition: transform 220ms cubic-bezier(0.22, 1, 0.36, 1), height 160ms ease;
  box-shadow: 0 -12px 40px rgba(15, 23, 42, 0.18);
  display: flex;
  flex-direction: column;
  will-change: transform, height;
}

.rtv-sheet-panel.is-visible {
  transform: translateY(0);
}

.rtv-sheet-panel.is-dragging {
  transition: none;
}

.rtv-sheet-handle {
  display: flex;
  justify-content: center;
  padding: 10px 0 6px;
  cursor: grab;
  touch-action: none;
  -webkit-user-select: none;
  user-select: none;
}

.rtv-sheet-handle:active {
  cursor: grabbing;
}

.rtv-sheet-grabber {
  border-radius: 999px;
  width: 44px;
  height: 5px;
  background: #d0d5dd;
}

.rtv-sheet-content {
  flex: 1;
  overflow-y: auto;
  padding: 0 16px 16px;
  overscroll-behavior: contain;
}

@keyframes rtv-sheet-fade-in {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@media (max-width: 640px) {
  .rtv-sheet-panel {
    border-top-left-radius: 14px;
    border-top-right-radius: 14px;
  }
}
</style>


